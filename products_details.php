<?php
  include_once 'database.php';
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['sid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Soccer Shoes Ordering System : Products Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM tbl_products_a189647 WHERE fld_product_num = :pid");
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $pid = $_GET['pid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
  ?>

  <div class="container-fluid">
    <tr>
           <?php if ($readrow['fld_product_image'] == "" ) {
        echo "No image";
      }
      else { ?>
      <img src="products/<?php echo $readrow['fld_product_image'] ?>" class="img-responsive">
      <?php } ?>

        </tr>
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Product Details</strong></div>
          <div class="panel-body">
            Below are specifications of the product.
          </div>
          <table class="table">
            <tr>
              <td class="col-xs-4 col-sm-4 col-md-4"><strong>Product ID</strong></td>
              <td><?php echo $readrow['fld_product_num'] ?></td>
            </tr>
            <tr>
              <td><strong>Name</strong></td>
              <td><?php echo $readrow['fld_product_name'] ?></td>
            </tr>
            <tr>
              <td><strong>Price</strong></td>
              <td>RM <?php echo $readrow['fld_product_price'] ?></td>
            </tr>
            <tr>
              <td><strong>Brand</strong></td>
              <td><?php echo $readrow['fld_product_brand'] ?></td>
            </tr>
            <tr>
              <td><strong>Playing Surface</strong></td>
              <td><?php echo $readrow['fld_product_surface'] ?></td>
            </tr>
            <tr>
              <td><strong>Size</strong></td>
              <td><?php echo $readrow['fld_product_size'] ?></td>
            </tr>
            <tr>
              <td><strong>Quantity</strong></td>
              <td><?php echo $readrow['fld_product_quantity'] ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
