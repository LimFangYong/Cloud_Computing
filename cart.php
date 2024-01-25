<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in the database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in the cart so just update the quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in the cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in the cart, this will add the first product to the cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in the cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Additional code to handle placing the order (if needed)
    
    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    header('Location: index.php?page=placeorder');
    exit;
}

// Check the session variable for products in the cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">

    <style>
        .btn-place-order {
            background-color: #28a745;
            color: #fff;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-place-order:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html"><h2>Online Store <em>Website</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="index.php?page=products">Products</a></li>

                        <li class="nav-item active"><a class="nav-link" href="index.php?page=cart">Cart</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading about-heading header-text" style="background-image: url(assets/images/heading-6-1920x500.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>Woodland</h4>
                        <h2>Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="container mt-5">
        <div class="row">
            <!-- Sample Product 1 -->
            <div class="col-lg-12">

                <form action="index.php?page=cart" method="post">
                    <?php if (empty($products)): ?>
                        <p colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                                    </h5>
                                    <a href="index.php?page=product&id=<?=$product['id']?>">
                                        <img src="imgs/<?=$product['img']?>" width="50" height="50" alt="<?=$product['name']?>">
                                    </a>

                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label for="quantity1">Price:</label>
                                            &dollar;<?=$product['price']?>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label for="quantity1">Quantity:</label>
                                            <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <input class="btn btn-success btn-update" type="submit" value="Update" name="update">
                                            <a class="btn btn-danger btn-delete" href="index.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p class="card-text"><strong>&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></strong></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div>
                            <span>Subtotal</span>
                            <span class="price">&dollar;<?=$subtotal?></span>
                        </div>
                        <div style="padding-top:10px;">
                            <input class="btn btn-place-order" type="submit" value="Place Order" name="placeorder">
                        </div>
                    <?php endif; ?>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>

</body>

</html>
