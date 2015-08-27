<?php

// Start the session
session_start();

// If the shopping cart does not exist
if( !isset($_SESSION['cart']) || isset($_GET['clearcart']) ) {

	// Create a cart
	$_SESSION['cart'] = [];
}

// Connect to database
$dbc = new mysqli('localhost', 'root', '', 'payment_gateway');

// If the user has submitted the add cart form
if( isset($_POST['add-to-cart']) ) {

	// Filter the ID
	$productID = $dbc->real_escape_string($_POST['productID']);

	// Find out info about this product
	$sql = "SELECT name, price
			FROM products
			WHERE ID = $productID";

	// Run the query
	$result = $dbc->query($sql);

	// Validation

	// Convert into an associative array
	$result = $result->fetch_assoc();
	
	// Another way to 'Add the item to the cart'
	// array_push($_SESSION['cart']);

	// See if the user is adding the same item to their cart
	$found = false;
	for( $i = 0; $i<count($_SESSION['cart']); $i++ ) {

		// Is the ID of the product they are adding, the same as the ID of this cart item?
		if( $_SESSION['cart'][$i]['ID'] == $productID ) {
			$found = true;

			// Yes they have already added this item to the cart
			// Grab the current quantity and add the quantity added to the cart
			$_SESSION['cart'][$i]['quantity'] += $_POST['quantity'];
		}

	}
	
	// Add the item to the cart
	if( $found == false ) {

		$_SESSION['cart'][] = [
								   'ID'       => $productID, 
								   'quantity' => $_POST['quantity'],
								   'name'     => $result['name'],
								   'price'    => $result['price'] 
						  	  ]; 
	}

	// Redirect
	header('Location: index.php');

}

// Include the header
include 'app/templates/header.php';

// Include the product list
include 'app/templates/product-list.php';

// Include the footer
include 'app/templates/footer.php';


















