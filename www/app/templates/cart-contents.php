<table border="1">
	<caption>Your Shopping Cart</caption>
	<tr>
		<th>Product Name</th>
		<th>Quantity</th>
		<th>Individual Price</th>
		<th>Total Price</th>
		<th>Change Quantity</th>
	</tr>

	<!-- Loop over each item in the cart -->
	<?php foreach( $_SESSION['cart'] as $cartItem ) : ?>

	<tr>
		<td><?= $cartItem['name']; ?></td>
		<td><?= $cartItem['quantity']; ?></td>
		<td>$<?= number_format($cartItem['price'], 2); ?></td>
		<td>$<?= number_format($cartItem['quantity'] * $cartItem['price'], 2) ; ?></td>
		<td></td>
	</tr>

	<?php endforeach; ?>

</table>

<a href="make-payment.php">Proceed to Payment</a>