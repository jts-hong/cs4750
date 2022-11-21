<?php
// Include config file
session_start();
require("config.php");
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        body {
            margin: 0;
            padding: 0;

        }

        .centered {
            margin: 0 auto;
            text-align: left;
            width: 800px;
        }
    </style>
</head>

<body>


    <?php
    $username = $_SESSION["username"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $rs_result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($rs_result);

    $user_id = $row["user_id"];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $address = $_POST['address'];
        if ($stmt = mysqli_prepare($link, "UPDATE users SET first_name=?,last_name=?, address=? WHERE user_id='$user_id'")) {

            mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name, $address);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_address = $address;



            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        $email = $_POST['email'];
        if ($stmt = mysqli_prepare($link, "UPDATE user_email SET email=? WHERE user_id='$user_id'")) {

            mysqli_stmt_bind_param($stmt, "s", $email);

            // Set parameters
            $param_email = $email;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        $gender = $_POST['gender'];
        if ($stmt = mysqli_prepare($link, "UPDATE user_gender SET gender=? WHERE user_id='$user_id'")) {

            mysqli_stmt_bind_param($stmt, "s", $gender);

            // Set parameters
            $param_gender = $gender;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        $phone = $_POST['phone'];
        if ($stmt = mysqli_prepare($link, "INSERT INTO user_phone VALUES ('$user_id',?)")) {

            mysqli_stmt_bind_param($stmt, "s", $phone);

            // Set parameters
            $param_phone = $phone;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        $desire_type = $_POST['desire_type'];
        $budget = $_POST['budget'];
        if ($stmt = mysqli_prepare($link, "UPDATE buyer SET desire_type=?,budget=? WHERE user_id='$user_id'")) {

            mysqli_stmt_bind_param($stmt, "sss", $desire_type, $budget);

            // Set parameters
            $param_desire_type = $desire_type;
            $param_budget = $budget;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        $message = "Record Modified Successfully";
    }


    $username = $_SESSION["username"];

    $query1 = "SELECT * FROM users WHERE username = '$username'";
    $rs_result1 = mysqli_query($link, $query1);
    $row1 = mysqli_fetch_array($rs_result1);

    $user_id = $row1["user_id"];

    $query2 = "SELECT * FROM user_email WHERE user_id = '$user_id'";
    $rs_result2 = mysqli_query($link, $query2);
    $row2 = mysqli_fetch_array($rs_result2);

    $query3 = "SELECT * FROM user_gender WHERE user_id = '$user_id'";
    $rs_result3 = mysqli_query($link, $query3);
    $row3 = mysqli_fetch_array($rs_result3);

    $query4 = "SELECT * FROM user_phone WHERE user_id = '$user_id'";
    $rs_result4 = mysqli_query($link, $query4);

    $query5 = "SELECT * FROM buyer WHERE user_id = '$user_id'";
    $rs_result5 = mysqli_query($link, $query5);
    $row5 = mysqli_fetch_array($rs_result5);

    $query6 = "SELECT car_id FROM likeCar WHERE user_id = '$user_id'";
    $rs_result6 = mysqli_query($link, $query6);
    $row6 = mysqli_fetch_array($rs_result6);

    ?>

    <br></br>
    <div class="wrapper" style="width:600px;margin:0 auto;">
        <?php include('header.html') ?>
        <h2 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Please add a car</h2>
        <div><?php if (isset($message)) {
                    echo $message;
                } ?></div>

        <br></br>
        <form method="POST">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control " value=<?php echo $row1['first_name']; ?>>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control " value=<?php echo $row1['last_name']; ?>>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control " value=<?php echo $row1['address']; ?>>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control " value=<?php echo $row2['email']; ?>>
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <input type="text" name="gender" class="form-control " value=<?php echo $row3['gender']; ?>>
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Add New Phone</label>
                <input type="text" name="phone" class="form-control ">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Desire Type</label>
                <input type="text" name="desire_type" class="form-control " value=<?php echo $row5['desire_type']; ?>>
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Budget</label>
                <input type="text" name="budget" class="form-control " value=<?php echo $row5['budget']; ?>>
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
        <br></br>
        <br></br>
        <div class="list-group w-auto">
            <h2>
                Phone List
            </h2>
            <br></br>
            <?php while ($row4 = mysqli_fetch_array($rs_result4)) { ?>
                <a href="" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <?php echo $row4['phone']; ?>
                        </div>
                    </div>
                </a>
            <?php }; ?>
        </div>
        <br></br>
        <div class="list-group w-auto">
            <h2>
                Liked Cars
            </h2>
            <?php while ($row6 = mysqli_fetch_array($rs_result6)) { ?>
                <a href="view.php?car_id=<?php echo $row6['car_id'];?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <?php echo $row6['car_id'];?>
                    </div>
                </a>
            <?php }; ?>
        </div>
    </div>


    <br></br>
    <br></br>
    <br></br>
    <?php include('footer.html') ?>

</body>

</html>