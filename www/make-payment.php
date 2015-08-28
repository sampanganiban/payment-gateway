<?php

// Start the session
session_start();

// Require the config file
require '../assets/config.php';

// Require the PxPay library
require 'app/PxPay_Curl.inc.php';

// Create an instance of the library
// Inside the brackets you enter where you want to redirect the user
$pxpay = new PxPay_Curl('https://sec.paymentexpress.com/pxpay/pxaccess.aspx', $PxPay_Userid, $PxPay_Key);

// Create a new request object
$request = new PxPayRequest();

// Prepare a URL to comeback to once payment has been completed
$http_host = getenv('HTTP_HOST'); // localhost
$folders   = getenv('SCRIPT_NAME');

// Where you want to take the user back to
$urlToComeBackTo = 'http://'.$http_host.$folders;

// Loop through the cart and calculate the grand total
$grandTotal = 0;
foreach( $_SESSION['cart'] as $cartItem ) {

	// Look at the how many items there are and the price and multiple them
	$grandTotal += $cartItem['quantity'] * $cartItem['price'];

}

// Prepare data for the PxPay
$request->setAmountInput( $grandTotal );
$request->setTxnType('Purchase'); // Transaction type
$request->setCurrencyInput('NZD');
$request->setUrlFail( PROJECT_ROOT.'payment-response.php' );
$request->setUrlSuccess( PROJECT_ROOT.'payment-response.php' );
$request->setTxnData1('Sam Panganiban');
$request->setTxnData2('20 Kent Terrace, Wellington, New Zealand');
$request->setTxnData3('sam@gmail.com');

// Prepare the request string out of the request data
$requestString = $pxpay->makeRequest($request);

// Send the request to be processed
$response = new MifMessage($requestString);

// Extract the URL so we can redirect the user
$urlToGoTo = $response->get_element_text('URI');

// Redirect the user
header('Location: '.$urlToGoTo);




















