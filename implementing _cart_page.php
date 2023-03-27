<?php

session_start();

// Include the cart class and other dependencies
require_once 'autoloader.php';
use MyApp\Cart;
use MyApp\Product;

// Check if the cart is already in the session
if (!isset($_SESSION['cart'])) {
    // If not, create a new cart object and store it in the session
    $cart = new Cart();
    $_SESSION['cart'] = $cart;
} else {
    // If so, retrieve the cart object from the session
    $cart = $_SESSION['cart'];
}

// Check if a product was added to the cart
if (isset($_POST['product_id'])) {
    // If so, retrieve the product details and add it to the cart
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product = new Product($product_id, $product_name, $product_price);
    $cart->addProduct($product);
    $_SESSION['cart'] = $cart;
}

// Check if a product quantity was updated or removed from the cart
if (isset($_POST['update']) && isset($_POST['product_id'])) {
    // If so, update or remove the product from the cart
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    if ($quantity == 0) {
        $cart->removeProduct($product_id);
    } else {
        $cart->updateQuantity($product_id, $quantity);
    }
    $_SESSION['cart'] = $cart;
}

// Display the products in the cart
echo '<h1>Shopping Cart</h1>';
echo '<table>';
echo '<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>';
$total = 0;
foreach ($cart->getProducts() as $product) {
    $subtotal = $product->getPrice() * $product->getQuantity();
    $total += $subtotal;
    echo '<tr>';
    echo '<td>' . $product->getName() . '</td>';
    echo '<td>$' . number_format($product->getPrice(), 2) . '</td>';
    echo '<td><form method="post"><input type="number" name="quantity" value="' . $product->getQuantity() . '"><input type="hidden" name="product_id" value="' . $product->getId() . '"><input type="submit" name="update" value="Update"></form></td>';
    echo '<td>$' . number_format($subtotal, 2) . '</td>';
    echo '<td><form method="post"><input type="hidden" name="product_id" value="' . $product->getId() . '"><input type="hidden" name="quantity" value="0"><input type="submit" name="update" value="Remove"></form></td>';
    echo '</tr>';
}
echo '<tr><th colspan="3">Total:</th><td>$' . number_format($total, 2) . '</td><td></td></tr>';
echo '</table>';
