<?php
// Initialize the session
session_start();
require("car-db.php");
require("config.php");
$list_of_cars = getAllCars();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <?php include('header.html') ?> 
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Ultimate 怨种 Website.</h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <div class="container">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
            <tr style="background-color:#B0B0B0">
                <th width="30%">Name</th>
                <th width="30%">Major</th>
                <th width="30%">Year</th>
            </tr>
            </thead>
            <?php foreach ($list_of_cars as $car_info): ?>
            <tr>
                <td><?php echo $car_info['make']; ?></td>
                <td><?php echo $car_info['year']; ?></td>
                <td><?php echo $car_info['model']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <?php include('footer.html') ?>
</body>
</html>`