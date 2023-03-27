<?php
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "ammar";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to create table
  $sql = "CREATE TABLE products (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(30) NOT NULL,
          description TEXT,
          price FLOAT(10,2) NOT NULL,
          quantity INT(6) NOT NULL
          )";

  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Table products created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
