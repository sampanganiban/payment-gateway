<?php

// Start session
session_start();

// Require the config file
require '../assets/config.php';

// Obtain the resullt from the address bar
$result = $_GET['result'];

// Require the PxPay library
require 'app/PxPay_Curl.inc.php';

// Create an instance of the library
$pxpay = new PxPay_Curl('https://sec.paymentexpress.com/pxpay/pxaccess.aspx', $PxPay_Userid, $PxPay_Key);

// Get the response from payment express
$response = $pxpay->getResponse($result);

// FOR TESTING
echo '<pre>';
print_r($response);

// Connect to the database
$dbc = new mysqli('localhost', 'root', '', 'payment_gateway');

// If the transaction was a success
if( $response->getSuccess() ) {

	// Success!

	// Extract the data
	$customerName    = $response->getTxnData1();
	$customerAddress = $response->getTxnData2();

	// Mix them together
	// \n\n means new line, it'll take the customers name, create a space and add the customer's address.
	$contact = $customerName."\n\n".$customerAddress;

	// Filter the contact info
	$contact = $dbc->real_escape_string($contact);

	// Create a new order
	$sql = "INSERT INTO orders 
			VALUES (NULL, 'approved', 'pending', '$contact', CURRENT_TIMESTAMP, NULL)";

	// Run the query
	$dbc->query($sql);

	// insert_id gets the ID of the new order
	$orderID = $dbc->insert_id;

	// Loop through the cart contents and add them to the ordered products table
	foreach($_SESSION['cart'] as $cartItem ) {

		// Extract the data from the database
		$productID = $cartItem['ID'];
		$quantity  = $cartItem['quantity'];
		$price 	   = $cartItem['price'];
		
		// Prepare SQL
		$sql = "INSERT INTO ordered_products
				VALUES (NULL, $orderID, $productID, $quantity, $price)";

		// Run the SQL
		$dbc->query($sql);


	}

	// Clear the cart
	$_SESSION['cart'] = [];

} else {

	// Fail!



























}