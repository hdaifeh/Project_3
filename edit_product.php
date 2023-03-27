<?php
require_once "pdo_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = $_POST["price"];
  $quantity = $_POST["quantity"];

  $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?");
  $stmt->execute([$name, $description, $price, $quantity, $id]);

  header("Location: products.php");
  exit;
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
</head>
<body>
  <h1>Edit Product</h1>
  <form method="post">
    <input type="hidden" name="id" value="<?= $product["id"] ?>">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $product["name"] ?>"><br>
    <label>Description:</label><br>
    <textarea name="description"><?= $product["description"] ?></textarea><br>
    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" value="<?= $product["price"] ?>"><br>
    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="<?= $product["quantity"] ?>"><br>
    <button type="submit">Save</button>
  </form>
</body>
</html>
