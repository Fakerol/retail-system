<?php
  include_once 'orders_details_crud.php';
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
  
  <title>My Soccer Ordering System : Orders Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
 
<?php include_once 'nav_bar.php'; ?>
 
    <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_orders_a189647, tbl_staffs_a189647,
          tbl_customers_a189647 WHERE
          tbl_orders_a189647.fld_staff_num = tbl_staffs_a189647.fld_staff_num AND
          tbl_orders_a189647.fld_customer_num = tbl_customers_a189647.fld_customer_num AND
          fld_order_num = :oid");
      $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
        $oid = $_GET['oid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
      }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Order Details</strong></div>
        <div class="panel-body">
            Below are details of the order.
        </div>
        <table class="table">
          <tr>
            <td class="col-xs-4 col-sm-4 col-md-4"><strong>Order ID</strong></td>
            <td><?php echo $readrow['fld_order_num'] ?></td>
          </tr>
          <tr>
            <td><strong>Order Date</strong></td>
            <td><?php echo $readrow['fld_order_date'] ?></td>
          </tr>
          <tr>
            <td><strong>Staff</strong></td>
            <td><?php echo $readrow['fld_staff_fname']." ".$readrow['fld_staff_lname'] ?></td>
          </tr>
          <tr>
            <td><strong>Customer</strong></td>
            <td><?php echo $readrow['fld_customer_fname']." ".$readrow['fld_customer_lname'] ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Add a Product</h2>
      </div>
      <form action="orders_details.php" method="post" class="form-horizontal" name="frmorder" id="forder">
      <div class="form-group">
          <label for="prd" class="col-sm-3 control-label">Product</label>
          <div class="col-sm-9">
            <select name="pid" class="form-control" id="prd">
              <option value="">Please select</option>
           <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_products_a189647");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $productrow) {
      ?>

        <option value="<?php echo $productrow['fld_product_num']; ?>"><?php echo $productrow['fld_product_brand']." ".$productrow['fld_product_name']; ?></option>
      <?php
      }
      $conn = null;
      ?>
          </select>
        </div>
      </div>
      <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Quantity</label>
          <div class="col-sm-9">
            <input name="quantity" type="number" class="form-control" id="qty" min="1">
          </div>
      </div>
      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <input name="oid" type="hidden" value="<?php echo $readrow['fld_order_num'] ?>">
        <button class="btn btn-default" type="submit" name="addproduct"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Product</button>
        <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Products in This Order</h2>
      </div>
      <table class="table table-striped table-bordered">
      <tr>
        <th>Order Detail ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th></th>
      </tr>
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_orders_details_a189647,
            tbl_products_a189647 WHERE
            tbl_orders_details_a189647.fld_product_num = tbl_products_a189647.fld_product_num AND
          fld_order_num = :oid");
          $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
          $oid = $_GET['oid'];
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $detailrow) {
      ?>
      <tr>
        <td><?php echo $detailrow['fld_order_detail_num']; ?></td>
        <td><?php echo $detailrow['fld_product_name']; ?></td>
        <td><?php echo $detailrow['fld_order_detail_quantity']; ?></td>
        <td>
          <a href="orders_details.php?delete=<?php echo $detailrow['fld_order_detail_num']; ?>&oid=<?php echo $_GET['oid']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
        </td>
      </tr>
      <?php } ?>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <a href="invoice.php?oid=<?php echo $_GET['oid']; ?>" target="_blank" role="button" class="btn btn-primary btn-lg btn-block">Generate Invoice</a>
    </div>
  </div>
  <br>
</div>

 <script type="text/javascript">
 
  function validateForm() {
 
      var x = document.forms["frmorder"]["pid"].value;
      var y = document.forms["frmorder"]["quantity"].value;
      //var x = document.getElementById("prd").value;
      //var y = document.getElementById("qty").value;
      if (x == null || x == "") {
          alert("Product must be selected");
          document.forms["frmorder"]["pid"].focus();
          //document.getElementById("prd").focus();
          return false;
      }
      if (y == null || y == "") {
          alert("Quantity must be filled out");
          document.forms["frmorder"]["quantity"].focus();
          //document.getElementById("qty").focus();
          return false;
      }
       
      return true;
  }
 
</script>
</body>
</html>