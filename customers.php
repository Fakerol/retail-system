<?php
  include_once 'customers_crud.php';
  // Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
// Check if the user is a supervisor, admin or normal staff
$isAdmin = ($_SESSION['level'] === 'Admin');
$isSupervisor = ($_SESSION['level'] === 'Supervisor');
$isNormalStaff = ($_SESSION['level'] === 'Normal Staff');

?>
 
<!DOCTYPE html>
<html>
<head>
  <title>My Soccer Shoes Ordering System : Customers</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  
   <?php include_once 'nav_bar.php'; ?>
<?php if(!$isNormalStaff){?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Create New Customer</h2>
      </div>
      <form action="customers.php" method="post"  class="form-horizontal">

      <div class="form-group">
        <label for="customerid" class="col-sm-3 control-label">Customer ID</label>
          <div class="col-sm-9">
            <input name="cid" type="text" class="form-control" id="customerid" placeholder="Customer ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_num']; ?>" required> <br>
        </div>
      </div>

     <div class="form-group">
        <label for="firstname" class="col-sm-3 control-label">First Name</label>
          <div class="col-sm-9">
            <input name="fname" type="text" class="form-control" id="firstname" placeholder="First name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_fname']; ?>" required> <br>
        </div>
     </div>
      
     <div class="form-group">
        <label for="lastname" class="col-sm-3 control-label">Last Name</label>
         <div class="col-sm-9">
          <input name="lname" type="text" class="form-control" id="lastname" placeholder="lastname" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_lname']; ?>" required> <br>
      </div> 
     </div>
  
      <div class="form-group">
        <label for="gender" class="col-sm-3 control-label">Gender</label>
         <div class="col-sm-9">

          <div class="radio">
            <label>
             <input name="gender" type="radio" id="gender" value="Male" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_gender']=="Male") echo "checked"; ?> required> Male
            </label>
          </div>

          <div class="radio">
            <label>
              <input name="gender" type="radio" id="gender" value="Female" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_gender']=="Female") echo "checked"; ?>required> Female <br>
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="address" class="col-sm-3 control-label">Address</label>
         <div class="col-sm-9">
            <input name="address" type="text" class="form-control" id="address" placeholder="Address" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_address']; ?>" required> <br>
      </div>
        </div>

     <div class="form-group">
        <label for="phonenumber" class="col-sm-3 control-label">Phone Number</label>
         <div class="col-sm-9">
          <input name="phone" type="text" class="form-control" id="phonenumber" placeholder="Phone number" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_phone']; ?>"required <br>
        </div>
      </div>

     <div class="form-group">
        <label for="email" class="col-sm-3 control-label">Email</label>
         <div class="col-sm-9">
          <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_email']; ?>" required> <br>        
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
           <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldpid" value="<?php echo $editrow['fld_customer_num']; ?>">
           <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
          <?php } else { ?>
          <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
          <?php } ?>
          <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
         </div>
      </div>

    </form>
<?php } ?> 
     <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Customers List</h2>
      </div>
      <table class="table table-striped table-bordered">
      <tr>
        <th>Customer ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th></th>
      </tr>
      <?php
      // Read
      $per_page = 5;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("select * from tbl_customers_a189647 LIMIT $start_from, $per_page");
        $stmt->execute();
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['fld_customer_num']; ?></td>
        <td><?php echo $readrow['fld_customer_fname']; ?></td>
        <td><?php echo $readrow['fld_customer_lname']; ?></td>
        <td><?php echo $readrow['fld_customer_gender']; ?></td>
        <td><?php echo $readrow['fld_customer_address']; ?></td>
        <td><?php echo $readrow['fld_customer_phone']; ?></td>
        <td><?php echo $readrow['fld_customer_email']; ?></td>

      <?php if(!$isNormalStaff){?>
        <td>
          <a href="customers.php?edit=<?php echo $readrow['fld_customer_num']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="customers.php?delete=<?php echo $readrow['fld_customer_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
        </td>
      <?php }?>

      </tr>
      <?php
      }
      $conn = null;
      ?>
    </table>
 </div>
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
          <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_customers_a189647");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
          <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
          <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"customers.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"customers.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
</body>
</html>