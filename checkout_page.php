checkout page that displays the summary of the order and allows the user to complete the order:
<?php
session_start();

require_once 'pdo_connect.php';

$products = array();
$total_price = 0;

if (count($_SESSION['cart']) > 0) {
  // Get the products in the cart from the database
  $product_ids = implode(',', array_keys($_SESSION['cart']));
  $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($product_ids)");
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Calculate the total price of the products in the cart
  foreach ($products as $product) {
    $product_id = $product['id'];
    $quantity = $_SESSION['cart'][$product_id];
    $product_price = $product['price'];
    $total_price += $quantity * $product_price;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Insert the order into the database
  $customer_name = $_POST['customer_name'];
  $customer_email = $_POST['customer_email'];
  $customer_address = $_POST['customer_address'];

  $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_address, total_price) VALUES (?, ?, ?, ?)");
  $stmt->execute([$customer_name, $customer_email, $customer_address, $total_price]);

  $order_id = $pdo->lastInsertId();

  // Insert the ordered products into the database
  foreach ($products as $product) {
    $product_id = $product['id'];
    $quantity = $_SESSION['cart'][$product_id];

    $stmt = $pdo->prepare("INSERT INTO ordered_products (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
  }

  // Clear the cart and redirect to the confirmation page
  $_SESSION['cart'] = array();
  header('Location: confirmation.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
</head>
<body>
  <h1>Checkout</h1>

  <h2>Order Summary</h2>

  <?php if (count($products) > 0): ?>
    <table>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
      </tr>
      <?php foreach ($products as $product): ?>
        <?php
          $product_id = $product['id'];
          $quantity = $_SESSION['cart'][$product_id];
          $subtotal = $quantity * $product['price'];
        ?>
        <tr>
          <td><?= $product['name'] ?></td>
          <td><?= $product['description'] ?></td>
          <td><?=
            number_format($product['price'], 2) // displays the price with 2 decimal places
          ?></td>
          <td><?= $quantity ?></td>
          <td><?=
            number_format($subtotal, 2) // displays the subtotal with 2 decimal places
          ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="4" style="text-align:right">Total:</td>
        <td><?=
          number_format($total_price, 2) // displays the total price with 2 decimal places
        ?></td>
      </tr
      </table>
      <h2>Customer Information</h2>

<form method="POST">
  <label for="customer_name">Name:</label>
  <input type="text" id="customer_name" name="customer_name" required><br><br>

  <label for="customer_email">Email:</label>
  <input type="email" id="customer_email" name="customer_email" required><br><br>

  <label for="customer_address">Address:</label>
  <textarea id="customer_address" name="customer_address" required></textarea><br><br>

  <button type="submit">Complete Order</button>
</form>
<?php else: ?>
    <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>