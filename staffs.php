<?php
include_once 'staffs_crud.php';
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user is a supervisor or admin
$isAdmin = ($_SESSION['level'] === 'Admin');
$isSupervisor = ($_SESSION['level'] === 'Supervisor');
$isNormalStaff = ($_SESSION['level'] === 'Normal Staff');

?>
 
<!DOCTYPE html>
<html>
<head>
  <title>My Soccer Shoes Ordering System : Staffs</title>
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
 //Display the form only if the user is not "Normal Staff"
 if(!$isNormalStaff){?>
<div class="container-fluid">
  
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Create New Staff</h2>
      </div>
      <form action="staffs.php" method="post"  class="form-horizontal">

      <div class="form-group">
        <label for="staffid" class="col-sm-3 control-label">Staff ID</label>
          <div class="col-sm-9">
            <input name="sid" type="text" class="form-control" id="staffid" placeholder="Staff ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_num']; ?>" required> <br>
        </div>
      </div>

     <div class="form-group">
        <label for="firstname" class="col-sm-3 control-label">First Name</label>
          <div class="col-sm-9">
            <input name="fname" type="text" class="form-control" id="firstname" placeholder="First name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_fname']; ?>" required> <br>
        </div>
     </div>
      
     <div class="form-group">
        <label for="lastname" class="col-sm-3 control-label">Last Name</label>
         <div class="col-sm-9">
          <input name="lname" type="text" class="form-control" id="lastname" placeholder="lastname" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_lname']; ?>" required> <br>
      </div> 
     </div>
  
      <div class="form-group">
        <label for="gender" class="col-sm-3 control-label">Gender</label>
         <div class="col-sm-9">

          <div class="radio">
            <label>
             <input name="gender" type="radio" id="gender" value="Male" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Male") echo "checked"; ?> required> Male
            </label>
          </div>

          <div class="radio">
            <label>
              <input name="gender" type="radio" id="gender" value="Female" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Female") echo "checked"; ?>required> Female <br>
            </label>
          </div>
        </div>
      </div>


     <div class="form-group">
        <label for="phonenumber" class="col-sm-3 control-label">Phone Number</label>
         <div class="col-sm-9">
          <input name="phone" type="text" class="form-control" id="phonenumber" placeholder="Phone number" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_phone']; ?>"required <br>
        </div>
      </div>

     <div class="form-group">
        <label for="email" class="col-sm-3 control-label">Email</label>
         <div class="col-sm-9">
          <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_email']; ?>" required> <br>        
        </div>
      </div>


     <div class="form-group">
          <label for="position" class="col-sm-3 control-label">Position</label>
          <div class="col-sm-9">
       <td><select name="position" class="form-control" id="position" required>
       
        <option value="Sale Executive" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_position']=="Sale Executive") echo "selected"; ?>>Sale Executive</option>
        <option value="Sale Manager" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_position']=="Sale Manager") echo "selected"; ?>>Sale Manager</option>
        <option value="Inventory Associate" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_position']=="Inventory Associate") echo "selected"; ?>>Inventory Associate</option>
        </select> </td><br>
          </div>
      </div>

      <div class="form-group">
          <label for="level" class="col-sm-3 control-label">Staff Level</label>
          <div class="col-sm-9">
       <td><select name="level" class="form-control" id="level" required>
       
        <option value="Normal Staff" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_level']=="Normal Staff") echo "selected"; ?>>Normal Staff</option>
        <option value="Supervisor" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_level']=="Supervisor") echo "selected"; ?>>Supervisor</option>
        <option value="Admin" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_level']=="Admin") echo "selected"; ?>>Admin</option>
        </select> </td><br>
          </div>
      </div>

      <div class="form-group">
    <label for="userpassword" class="col-sm-3 control-label">Password</label>
    <div class="col-sm-9">
        <input name="userpassword" type="password" class="form-control" id="userpassword" placeholder="Password" 
            value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_password']; ?>" 
            <?php echo isset($_GET['edit']) ? 'readonly' : ''; ?> required>
        <br>        
    </div>
</div>

      <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit']) && $isAdmin) { ?>
                    <input type="hidden" name="oldsid" value="<?php echo $editrow['fld_staff_num']; ?>">
                    <button class="btn btn-default" type="submit" name="update">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update
                    </button>
                <?php } elseif (!$isAdmin && $isSupervisor) { ?>
                    <!-- Show only the update button for supervisors -->
                    <button class="btn btn-default" type="submit" name="update">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update
                    </button>
                <?php } else { ?>
                    <button class="btn btn-default" type="submit" name="create">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create
                    </button>
                <?php } ?>

                <button class="btn btn-default" type="reset">
                    <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear
                </button>
            </div>
        </div>

    </form>
</div>
</div>

     <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Staff List</h2>
      </div>
      
      <table class="table table-striped table-bordered" style="width:200%;">
      <tr>
        <th>Staff ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Position</th>
        <th>Level</th>
        <th>Hashed Password</th>
        <th></th>
      </tr>
      <?php
      error_reporting(E_ALL);
        ini_set('display_errors', 1);
      // Read
      $per_page = 30;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("select * from tbl_staffs_a189647 LIMIT $start_from, $per_page");
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
        <td><?php echo $readrow['fld_staff_num']; ?></td>
        <td><?php echo $readrow['fld_staff_fname']; ?></td>
        <td><?php echo $readrow['fld_staff_lname']; ?></td>
        <td><?php echo $readrow['fld_staff_gender']; ?></td>
        <td><?php echo $readrow['fld_staff_phone']; ?></td>
        <td><?php echo $readrow['fld_staff_email']; ?></td>
        <td><?php echo $readrow['fld_staff_position']; ?></td>
        <td><?php echo $readrow['fld_staff_level']; ?></td>
        <td><?php echo $readrow['fld_staff_password']; ?></td>

        <td>
            <a href="staffs.php?edit=<?php echo $readrow['fld_staff_num']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
    
          <?php if ($isAdmin) { ?>
            <a href="staffs.php?delete=<?php echo $readrow['fld_staff_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php } elseif ($isSupervisor) { ?>
            <!-- Hide the delete button for supervisors -->
            <style scoped> .btn-delete { display: none; } </style>
            <button class="btn btn-danger btn-xs btn-delete" role="button">Delete</button>
          <?php } ?>
        </td>
      </tr>

      <?php
      }
      $conn = null;
      ?>
    </table>
  </div>
 </div>
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
          <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a189647");
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
            <li><a href="staffs.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"staffs.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"staffs.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="staffs.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
    <?php } ?>
</body>
</html>