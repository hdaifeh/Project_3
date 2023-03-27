<?php
require_once "create_product.php";

require_once 'autoloader.php';

// Create a new database connection
$db = new PDO('mysql:host=localhost;dbname=mydatabase', 'myuser', 'mypassword');

// Create a new instance of the ProductRepository class
$repository = new ProductRepository($db);

// Handle the form submission to create a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the form data
    $errors = [];
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($price)) {
        $errors[] = 'Price is required.';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Price must be a number.';
    }

    // If there are no validation errors, create a new product and redirect to the products page
    if (empty($errors)) {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $repository->save($product);
        header('Location: products.php');
        exit;
    }
}

// Get all products from the database
$products = $repository->findAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price">
        </div>
        <button type="submit">Create Product</button>
    </form>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product->getName()); ?></td>
                    <td><?php echo htmlspecialchars($product->getPrice()); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $product->getId(); ?>">Edit</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
