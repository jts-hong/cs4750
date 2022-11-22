<?php 
session_start();
require("config.php");
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$number = $_GET['number'];
$sql = "DELETE FROM user_phone WHERE phone = $number"; 

if (mysqli_query($link, $sql)) {
    mysqli_close($link);
    header('Location: account.php'); //If book.php is your main page where you list your all records
    exit;
} else {
    echo "Error deleting record";
}



?>