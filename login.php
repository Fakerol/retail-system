<?php
include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Function to fetch user level from the database
function fetchUserLevel($conn, $sid) {
    $stmt = $conn->prepare("SELECT fld_staff_level FROM tbl_staffs_a189647 WHERE fld_staff_num = :sid");
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['fld_staff_level'] : null;
}

// Function to fetch user first name from the database
function fetchUserFirstName($conn, $sid) {
    $stmt = $conn->prepare("SELECT fld_staff_fname FROM tbl_staffs_a189647 WHERE fld_staff_num = :sid");
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['fld_staff_fname'] : null;
}

// Function to fetch user last name from the database
function fetchUserLastName($conn, $sid) {
    $stmt = $conn->prepare("SELECT fld_staff_lname FROM tbl_staffs_a189647 WHERE fld_staff_num = :sid");
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['fld_staff_lname'] : null;
}

// Initialize variables
$sid = "";
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $sid = $_POST["sid"];
    $userpassword = $_POST["userpassword"];

    // Query to retrieve the hashed password from the database
    $stmt = $conn->prepare("SELECT fld_staff_password FROM tbl_staffs_a189647 WHERE fld_staff_num = :sid");
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify the password
    if ($row && password_verify($userpassword, $row['fld_staff_password'])) {
        // Valid credentials, retrieve user level from the database
        $level = fetchUserLevel($conn, $sid);
        $fname = fetchUserFirstName($conn, $sid);
        $lname = fetchUserLastName($conn, $sid);
        session_start();
        $_SESSION['sid'] = $sid;
        $_SESSION['level'] = $level;  // Set the user level in the session
        $_SESSION['fname'] = $fname;  // Set the user fname in the session
        $_SESSION['lname'] = $lname;  // Set the user lname in the session
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login GoalKick</title>
    <link rel="stylesheet" href="style.css">

     <style>
        /* Add your custom styles here */
        .blue-container {
            background-color: #273c75; /* Blue color */
            border-radius: 10px; /* Border radius */
            padding: 20px; /* Add padding for content inside the container */
            color: #fff; /* Text color (white in this example) */
        }
    </style>
</head>

<body>
    <style>
    .center-container {
       
        height: 100vh; /* Set the height to the viewport height for vertical centering */
        margin-top: 200px; /* Adjust this value to set the distance from the top */
    }

   
</style>
    <div class="container center-container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <div class="blue-container">
                <div id="title" class="text-center">
                    <h3>Login</h3>
                </div>

                <form method="post" action="">
                    <label for="staffID">User ID</label>
                    <input type="text" name="sid" id="staffID" class="form-control" placeholder="User ID" value="<?php echo htmlspecialchars($sid); ?>" required><br>

                    <label for="userpassword">Password</label>
                    <input type="password" name="userpassword" id="userpassword" class="form-control" placeholder="Password" required><br>

                    <p class="error"><?php echo $errorMessage; ?></p>
                    <div class="text-center">
                    <input type="submit" name="submit" value="Login" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery scripts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
