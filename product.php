<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
                
                <li class="nav-item"><a class="nav-link" href="index.php?page=cart">Cart</a></li>
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
              <h2>Product Details</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="products">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-xs-12">
            <div>
				<img src="imgs/<?=$product['img']?>" alt="<?=$product['name']?>" class="img-fluid wc-image">
            </div>
          </div>

          <div class="col-md-8 col-xs-12">
		  
		  
            <form action="index.php?page=cart" method="post" class="form">
			<h2><?=$product['name']?></h2>

              <br>

              <p class="lead">
                <strong class="text-primary">
				&dollar;<?=$product['price']?>
            <?php if ($product['rrp'] > 0): ?>
            <span>&dollar;<?=$product['rrp']?></span>
            <?php endif; ?>
				</strong>
              </p>

              <br>

              <p class="lead">
                <?=$product['desc']?>
              </p>

              <br> 

              <div class="row">
                
                <div class="col-sm-8">
                  <label class="control-label"><h2>Quantity</h2></label>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
					  <input class="form-control" type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="" required>
						
                      </div>
                    </div>

                    <div class="col-sm-6" >
                      <input type="hidden" name="product_id" value="<?=$product['id']?>">
						<input class="btn btn-primary btn-block" type="submit" value="Add To Cart">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
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
