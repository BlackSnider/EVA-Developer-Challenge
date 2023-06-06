<?php
class CLibraries extends CLDatabase {
	
	private $apiKey;
	private $apiSharedSecret;
	private $redirectURI;
	private $scopes;
	
	public function __construct() {
		
	    $this->apiKey = MYSHOP_APIKEY;
		$this->apiSharedSecret = MYSHOP_APISHAREDSECRET;
		$this->scopes = MYSHOP_SCOPES;
		$this->redirectURI = REST_API_LINK;
		
	}
	
	public function installCustomShop($shop) {
		
		$installURL = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $this->apiKey . "&scope=" . $this->scopes . "&redirect_uri=" . urlencode($this->redirectURI);
		return $installURL;
		
	}
	
	public function generateToken() {
		
		$hmac = $_GET['hmac'];
		unset($_GET['hmac']);
		
		$params = $_GET;
		
		$ar= [];
	
		  foreach($params as $key=>$value){

			$key = str_replace("%","%25",$key);
			$key = str_replace("&","%26",$key);
			$key = str_replace("=","%3D",$key);
			$value = str_replace("%","%25",$value);
			$value = str_replace("&","%26",$value);

			$ar[] = $key."=".$value;
		  }

		$str = join('&',$ar);
		
		$computed_hmac = hash_hmac('sha256', $str, $this->apiSharedSecret,false); 
								
		// Use hmac data to check that the response is from Shopify or not
		if ("$hmac"=="$computed_hmac") {
		
			$queryResult = array(
								 "client_id" => $this->apiKey, 
								 "client_secret" => $this->apiSharedSecret, 
								 "code" => $params['code'] 
								 );
			
			$accessTokenURL = "https://" . $params['shop'] . "/admin/oauth/access_token";
		
			$sessionToken = $this->connect_curl($accessTokenURL, $queryResult);
				
			$this->update("Update eva_tbl_access set `accessToken` = :accessToken where accessTokenID = :accessTokenID",['accessTokenID' => 1,'accessToken' => $sessionToken]);
		
            if(empty($sessionToken)) {
				  $message = "Error! No generated token.";
			} else {
				  $message = "Access Token has been saved";
			}
		
		} else {
	
			$message = "This request is invalid.";
			
		}
		
		return $message;

	}
	
	
	public function insertComment($shop,$productID, $jsonData="") {
		
		$getAccessTokenResult = $this->select("Select accessToken from eva_tbl_access where accessTokenID = :accessTokenID",["accessTokenID"=>1]);
		
		$this->connect_curl_shopify_call("https://".$shop."/admin/products/".$productID."/metafields.json", $getAccessTokenResult[0]['accessToken'], $jsonData);
	
		$this->insert("INSERT INTO `eva_tbl_products_comments`(`productID`,`key`,`value`,`namespace`) VALUES (:productID,:key,:value,:namespace)", [ 'productID' => $productID, 'key' => $jsonData['metafield']['key'],'value' => $jsonData['metafield']['value'], 'namespace' => $jsonData['metafield']['namespace']]);
	
	}
	
	
	
	private function connect_curl_shopify_call($url, $accessToken, $data=array()) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER,   array( 
													 'Content-Type: application/json', 
													 'X-Shopify-Access-Token: '.$accessToken.''
													 )
				    );
	  
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		echo json_encode($data);
		echo $response;
		curl_close($ch);
		
	}
	
	private function connect_curl($url, $queryResult=array()) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($queryResult));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($queryResult));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		
		curl_close($ch);

		$result = json_decode($result, true);
		$accessToken = $result['access_token'];

		return $accessToken;
	
	}
		
	
}
?>