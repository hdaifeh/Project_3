$product_ids = implode(',', array_keys($_SESSION['cart']));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($product_ids)");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
