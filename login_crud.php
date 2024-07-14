<?php

include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$sid = "";
$userpassword = "";
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $sid = $_POST["sid"];
    $userpassword = $_POST["userpassword"];

    // Query to check if the provided credentials are valid using prepared statements
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a189647 WHERE fld_staff_num = :sid AND fld_staff_password = :userpassword");
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':userpassword', $userpassword, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // Valid credentials, redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        // Invalid credentials, display error message
        $errorMessage = "Invalid user ID or password. Please try again.";
    }
}

// Close the database connection
$conn = null;
?>
