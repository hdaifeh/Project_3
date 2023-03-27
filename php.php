Use PDO to connect to the database in your PHP code:
<?php
$dsn = "mysql:host=localhost;dbname=online_shopping";
$username = "username";
$password = "password";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit;
}
?>
