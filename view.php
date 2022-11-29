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


if (isset($_GET['car_id'])) {
  $car_id = $_GET['car_id'];
  $result = getCarDetails($car_id);
  $SellerResult = getSeller($result["user_id"]);
  $Seller_user = getUser(reset($SellerResult)["user_id"]);
  $SellerPhone = getUserPhone(reset($SellerResult)["user_id"]);
} else {
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

    * {
      box-sizing: border-box
    }

    /* Set a style for all buttons */
    button {
      background-color: #04AA6D;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }

    button:hover {
      opacity: 1;
    }

    /* Float cancel and delete buttons and add an equal width */

    .deletebtn {
      float: left;
      width: 50%;
    }

    /* Add a color to the cancel button */
    .cancelbtn {
      background-color: #ccc;
      color: black;
      margin: auto;
    }

    /* Add a color to the delete button */
    .deletebtn {
      background-color: #f44336;
    }

    /* Add padding and center-align text to the container */
    .container {
      padding: 16px;
      text-align: center;
    }

    /* The Modal (background) */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: #474e5d;
      padding-top: 50px;
    }

    /* Modal Content/Box */
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto 15% auto;
      /* 5% from the top, 15% from the bottom and centered */
      border: 1px solid #888;
      width: 80%;
      /* Could be more or less, depending on screen size */
    }

    /* Style the horizontal ruler */
    hr {
      border: 1px solid #f1f1f1;
      margin-bottom: 25px;
    }

    /* The Modal Close Button (x) */
    .close {
      position: absolute;
      right: 35px;
      top: 15px;
      font-size: 40px;
      font-weight: bold;
      color: #f1f1f1;
    }

    .close:hover,
    .close:focus {
      color: #f44336;
      cursor: pointer;
    }

    /* Clear floats */
    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }

    /* Change styles for cancel button and delete button on extra small screens */
    @media screen and (max-width: 300px) {

      .cancelbtn,
      .deletebtn {
        width: 100%;
      }
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
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#bootstrap" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4"> Make & Model</h3>
          <p><?php echo $result['make']; ?> <?php echo $result['model']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#cpu-fill" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Price</h3>
          <p><?php echo $result['selling_price']; ?>$ </p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#calendar3" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Year</h3>
          <p><?php echo $result['year']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#home" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Mileage</h3>
          <p><?php echo $result['mileage']; ?> miles</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#speedometer2" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Fuel Type</h3>
          <p><?php echo $result['fuel_type']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#toggles2" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Transmission</h3>
          <p><?php echo $result['transmission']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#geo-fill" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">MPG</h3>
          <p><?php echo $result['mpg']; ?></p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <svg class="bi text-muted flex-shrink-0 me-3" width="1.75em" height="1.75em">
          <use xlink:href="#tools" />
        </svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4">Availability</h3>
          <p><?php
              if ($result['availability'] == 1) {
                echo 'Yes';
              } else {
                echo 'No';
              }
              ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="px-4 py-5 my-5 text-center">
    <!-- <img class="d-block mx-auto mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="display-5 fw-bold">Description From the Seller</h1>
    <div class="col-lg-6 mx-auto">
      <?php echo $result['description'] ?>
      <p class="lead mb-4">
      </p>
      <button onclick="document.getElementById('id01').style.display='block'">Buy</button>
    </div>

  </div>





  <div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    <form class="modal-content" action="/action_page.php">
      <br />
      <br />
      <br />

      <div class="container">
        <h2>Seller Name: <?php echo reset($Seller_user)["first_name"]; ?></h2>
        <p>Seller Rating: <?php echo reset($SellerResult)["rating"]; ?></p>

        <?php
        foreach ($SellerPhone as $curPhone) :
          echo "<p> Seller Phone Number: {$curPhone['phone']} </p>";
        endforeach;
        ?>
        <br /><br />
        <br /><br />
        <button type="button" class="cancelbtn" onclick="document.getElementById('id01').style.display='none'">Close</button>

      </div>
      <br /><br />
    </form>
  </div>

  <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>

</html>