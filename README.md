# Edmar Cruz - Shopify Eva Developer Challenge 1 (REST API)

Create REST API that allows customers to leave comments on each product and stores them in a database, then display the comments on each product page.

# Requirements

REST Server should have the following softwares available:
- PHP 7 & above
- Apache (includes OpenSSL)
- MySQL/MariaDB
- React & Node

Shopify Store 
- Shopify partner account and development store
 
# Getting started

Create a MySQL database based on the attached SQL file (eva-challenge.sql)

Setting up the configuration (config.ini) 

```

; Location for the rest api
rest_api_link=[REST API server's code path]

; Credentials for the created shop
[credentials]
apiKey=[shopify partner's client key]
apiSharedSecret=[shopify partner's api secret]
scopes=[shopify scopes]
mysqlHost=[host of the mysql server]
mysqlUser=[mysql username]
mysqlPass=[mysql user password]
mysqlDB=[mysql database]
[/credentials]

```

Place the files to the webroot of the API Server

# Installation

Create an app on the Admin API console of your Shopify store.

Once install, generate a token run the following on your browser.

```

https://<ip address of the REST server>/index.php?steps=install&shop=[shopifystore.myshopify.com]

```

or via SSH terminal through curl

```

curl -k -X POST https://<ip address and code path of the REST server>/index.php?steps=install&shop=[shopifystore.myshopify.com]

```

The generated token will be save on the MySQL database.

# Displaying product comments 

Create metafields on Settings->Custom Data. 

```

Customer Name                              Content Type
product.metafields.custom.customer_name    Single line text
product.metafields.custom.comments         Multi-line text

```

On storefront, create a Custom Liquid file containing the following syntax.

```

{%- if product.metafields.custom!= blank -%}

<h3>{{ product.metafields.custom.customer_name }}</h3>

<p><i>{{ product.metafields.custom.comments }}</i></p>

{%- endif -%}

```

Open the PHP code named index.php and change the variables given.

```

    case "call":
	
	   $productID = '<product id>';
	   $customerName = 'GreenLantern';
	   $comments = '<product comments>';
	   
	   // Customer Name	   
	   $productMetaData1 = array(
							    "metafield" => array(
												   
														 "namespace"   =>  "custom",
														 "key"         =>  "customer_name",
														 "value"       =>  $customerName
														
													)
							    );
	
						 
	   $myShopClass->insertComment($shop,$productID,$productMetaData1);
	   
	   // Customer comments
	   $productMetaData2 = array(
							    "metafield" => array(
												   
														 "namespace"   =>  "custom",
														 "key"         =>  "comments",
														 "value"       =>  $comments
														
													)
							    );
	
						  
	
	   $myShopClass->insertComment($shop,$productID,$productMetaData2);
	
	break;


```

To run, execute the following to generate JSON data.

```

https://<ip address and code path of the REST server>/index.php?steps=call&shop=[shopifystore.myshopify.com]


```

or via SSH terminal through curl

```

curl -k -X POST https://<ip address and code path of the REST server>/index.php?steps=call&shop=[shopifystore.myshopify.com]

```

If a ReactJS code will be used.

```

fetch(
  '[shopifystore.myshopify.com]/admin/products/[product-id]/metafields.json',
  {
    body: JSON.stringify({
      metafield: {
        namespace: 'custom',
        key: 'comments',
        value: '[comment-value]',
        value_type: 'string',
      },
    }),
    method: 'POST',
    headers: {
      'X-Shopify-Access-Token': '[partner's generated access token]',
      'Content-Type': 'application/json',
    },
  },
);

```
# Result

The code response will display in JSON format. The result shall display and record the comments on storefront via Shopify database inserting also on REST API database.

```

{"metafield":{"namespace":"custom","key":"customer_name","value":"GreenLantern"}}{"metafield":{"owner_id":8299532386592,"namespace":"custom","key":"customer_name","value":"GreenLantern","id":28995616178464,"description":null,"created_at":"2023-06-06T01:49:14-04:00","updated_at":"2023-06-06T01:49:14-04:00","owner_resource":"product","type":"single_line_text_field","admin_graphql_api_id":"gid:\/\/shopify\/Metafield\/28995616178464"}}{"metafield":{"namespace":"custom","key":"comments","value":"The girl in town has plenty of flowers to buy with."}}{"metafield":{"owner_id":8299532386592,"namespace":"custom","key":"comments","value":"The girl in town has plenty of flowers to buy with.","id":28991109628192,"description":null,"created_at":"2023-06-05T09:08:30-04:00","updated_at":"2023-06-05T09:08:30-04:00","owner_resource":"product","type":"multi_line_text_field","admin_graphql_api_id":"gid:\/\/shopify\/Metafield\/28991109628192"}}


```

# Edmar Cruz - Shopify Eva Developer Challenge 4 (WISHLIST)

Installed a built in wishlist app

Put a block or section or liquid file that will called a shareable link to call the collection or category page of the selected wishlist.

Please visit the store https://edmar-furniture-shop.myshopify.com/ for more.
