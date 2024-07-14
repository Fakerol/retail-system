<!--
Matric Number: A189647
Name: MUHAMAD FAKHRUL NAJMI BIN ABD AZIZ
-->
<?php
// Start session
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
   
  <title>My Soccer Shoes Ordering System : Products</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  
    <style type="text/css">
      html {
        width:100%;
        height:100%;
        background:url(logo-1.png) center center no-repeat;
        min-height:100%;
      }
    </style>
</head>
<body>
  <?php include_once 'nav_bar.php';?>

   
 
</body>
</html>