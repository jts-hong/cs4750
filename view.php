<?php
// Initialize the session
session_start();
require("config.php");
require("car-db.php");
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_GET['car_id'])){
    $car_id = $_GET['car_id'];
    $result = getCarDetails($car_id);
}else{
    echo "<h1 class='text-danger'> Please check details and try again</h>";
}

/* $query = 'SELECT * FROM vehicle WHERE car_id = $car_id';
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result); */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>


<body>
<?php include('header.html') ?>

<br></br>

<div class="container px-4 py-5" id="icon-grid">
    <h2 class="pb-2 border-bottom"> Detailed Parameters</h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4"> Make & Model</h3>
          <p><?php echo $result['make']; ?>   <?php echo $result['model']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#cpu-fill"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Price</h3>
          <p><?php echo $result['selling_price'];?>$ </p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Year</h3>
          <p><?php echo $result['year']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#home"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Mileage</h3>
          <p><?php echo $result['mileage']; ?> miles</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#speedometer2"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Fuel Type</h3>
          <p><?php echo $result['fuel_type']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#toggles2"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Transmission</h3>
          <p><?php echo $result['transmission']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#geo-fill"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">MPG</h3>
          <p><?php echo $result['mpg']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#tools"/></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Availability</h3>
          <p><?php 
                    if ($result['availability']==1){
                      echo 'Yes'; 
                     }else{
                      echo 'No';
                  }
          ?></p>
        </div>
      </div>
    </div>
  </div>

<div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold">Description From the Seller</h1>
    <div class="col-lg-6 mx-auto">
        <?php echo $result['description']?>
      <p class="lead mb-4">
      </p>
    </div>
  </div>



  </body>

</html>