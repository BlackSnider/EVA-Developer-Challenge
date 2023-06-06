<?php
// Include require libraries
require_once("libraries/cldatabase.php");
require_once("libraries/clibraries.php");

// Get configuration options
$config = parse_ini_file("config/config.ini",true);

// Define constants
define('REST_API_LINK', $config['rest_api_link']);
define('MYSHOP_APIKEY',$config["credentials"]["apiKey"]);
define('MYSHOP_APISHAREDSECRET',$config["credentials"]["apiSharedSecret"]);
define('MYSHOP_SCOPES',$config["credentials"]["scopes"]);

// MySQL connection credentials
define('DB_HOST',$config["credentials"]['mysqlHost']);
define('DB_USER',$config["credentials"]["mysqlUser"]);
define('DB_PASS',$config["credentials"]["mysqlPass"]);
define('DB_NAME',$config["credentials"]["mysqlDB"]);


$myShopClass = new CLibraries();

$steps = $_REQUEST['steps'];
$shop = $_REQUEST['shop'];

switch($steps) {
	
	case "install":
	   
	   $initiateResult = $myShopClass->installCustomShop($shop);
	   
	   header("Location: " . $initiateResult);
	   
	break;
	
	case "call":
	
	   $productID = 8299532386592;
	   $customerName = 'GreenLantern';
	   $comments = 'The girl in town has plenty of flowers to buy with.';
	
	   // Customer Name	   
	   $productMetaData1 = array(
							    "metafield" => array(
												   
														 "namespace"   =>  "custom",
														 "key"         =>  "customer_name",
														 "value"       =>  $customerName
														
													)
							    );
	
						 
	   $myShopClass->insertComment($shop,$productID,$productMetaData1);
	
	   // Customer Comments
	   $productMetaData2 = array(
							   "metafield" => array(
												   
														 "namespace"   =>  "custom",
														 "key"         =>  "comments",
														 "value"       =>  $comments
														
													)
							   );
	
						  
	
	   $myShopClass->insertComment($shop,$productID,$productMetaData2);
	
	
	break;
	
	default:
	
	   echo $myShopClass->generateToken($shop);
	   
	break;
	
	
	
}



?>