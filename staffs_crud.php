<?php
 
include_once 'database.php';
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
 
  try {
 
    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a189647(fld_staff_num, fld_staff_fname, fld_staff_lname,
      fld_staff_gender, fld_staff_phone, fld_staff_email, fld_staff_position, fld_staff_level, fld_staff_password) VALUES(:sid, :fname, :lname, :gender, :phone, :email, :position, :level, :userpassword)");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
    $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->bindParam(':userpassword', $userpassword, PDO::PARAM_STR);

    $sid = $_POST['sid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender =  $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $level = $_POST['level'];
    $userpassword = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);

         
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Update
if (isset($_POST['update'])) {
   
  try {
 
    $stmt = $conn->prepare("UPDATE tbl_staffs_a189647 SET
      fld_staff_num = :sid, fld_staff_fname = :fname,
      fld_staff_lname = :lname, fld_staff_gender = :gender,
      fld_staff_phone = :phone, fld_staff_email = :email, fld_staff_position = :position, fld_staff_level = :level, fld_staff_password = :userpassword

      WHERE fld_staff_num = :oldsid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
    $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->bindParam(':userpassword', $userpassword, PDO::PARAM_STR);
    $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);
       
    $sid = $_POST['sid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
     $position = $_POST['position'];
     $level = $_POST['level'];
     $userpassword = $_POST['userpassword'];
    $oldsid = $_POST['oldsid'];
         
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $conn->prepare("DELETE FROM tbl_staffs_a189647 where fld_staff_num = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
   
  try {
 
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a189647 where fld_staff_num = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
  $conn = null;
 
?>