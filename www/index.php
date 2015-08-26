<?php

// Start the session
session_start();

// If the shopping cart does not exist
if( !isset($_SESSION['cart']) ) {
	// Create a cart
	$_SESSION['cart'] = [];
}

// Connect to database
$dbc = new mysqli('localhost', 'root', '', 'payment_gateway');

// Include the header
include 'app/templates/header.php';

// Include the product list
include 'app/templates/product-list.php';

// Include the footer
include 'app/templates/footer.php';

