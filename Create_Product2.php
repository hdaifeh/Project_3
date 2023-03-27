<?php
require_once "pdo_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = $_POST["price"];
  $quantity = $_POST["quantity"];

  $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $description, $price, $quantity]);

  header("Location: products.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Product</title>
</head>
<body>
  <h1>Create Product</h1>
  <form method="post">
    <label>Name:</label><br>
    <input type="text" name="name"><br>
    <label>Description:</label><br>
    <textarea name="description"></textarea><br>
    <label>Price:</label><br>
    <input type="number" name="price" step="0.01"><br>
    <label>Quantity:</label><br>
    <input type="number" name="quantity"><br>
    <button type="submit">Create</button>
  </form>
</body>
</html>
