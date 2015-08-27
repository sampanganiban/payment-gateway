<?php

	// If the user already has this item in the cart then we want to make sure they can't add more than what's in the database
	// If we subtract their cart quantity against the database quantity, then we can help prevent this issue
	for( $i = 0; $i<count($_SESSION['cart']); $i++ ) {

		// If the ID of this product is the same as one in the cart
		if( $row['ID'] == $_SESSION['cart'][$i]['ID'] ) {
			$newQuantity = $row['quantity'] -= $_SESSION['cart'][$i]['quantity'];
			$inCart = $_SESSION['cart'][$i]['quantity'];
		}

	}

	// If the $newQuantity variable doesn't exist then create it and display the default database quantity
	if( !isset($newQuantity) ) {
		$newQuantity = $row['quantity'];
	}


?>

<form action="index.php" method="post">

	<label for="quantity<?= $row['ID']; ?>">Choose the quantity: </label>
	<input type="number" id="quantity<?= $row['ID']; ?>" name="quantity" min="1" max="<?= $newQuantity; ?>" value="1">
	
	<input type="hidden" name="productID" value="<?= $row['ID']; ?>">
	<input type="submit" value="Add to Cart" name="add-to-cart">

</form>

<?php
	
	// If the user had this item in their cart, tell them
	if( isset($inCart) ) {
		echo '<ul>';
		echo '<li>Already in Cart</li>';
		echo '<li>In Cart: '.$inCart.'</li>';
		echo '</ul>';
		unset($inCart);
	}

	unset($newQuantity);


?>