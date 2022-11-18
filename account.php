<?php
    // Include config file
    session_start();
    require("config.php");
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    //Adding user email to user_email
    // $username = $_SESSION["username"];


    // $em = "SELECT user_id FROM users WHERE username = '$username'";
    // $q = mysqli_query($link,$em);
    // $n = mysqli_fetch_array($q);
    // $user_id = intval($n['user_id']);
    // $email = trim($_POST["email"]);
    // $sql = "UPDATE user_email SET email= (?) WHERE user_id = '$user_id'";

    // if($stmt = mysqli_prepare($link, $sql)){
    //     // Bind variables to the prepared statement as parameters
    //     mysqli_stmt_bind_param($stmt, "s",  $email);
        
    //     // Set parameters
    //     $param_email = $email;

        
    //     // Attempt to execute the prepared statement
    //     if(mysqli_stmt_execute($stmt)){
    //         // Redirect to login page
    //         #header("location: login.php");
    //     } else{
    //         echo "Oops! Something went wrong. Please try again later.";
    //     }

    //     // Close statement
    //     mysqli_stmt_close($stmt);
    // }

    // //Adding user phone to user_phone

    // $em = "SELECT user_id FROM users WHERE username = '$username'";
    // $q = mysqli_query($link,$em);
    // $n = mysqli_fetch_array($q);
    // $id = intval($n['user_id']);
    // $phone = trim($_POST["phone"]);
    // $sql = "INSERT INTO user_phone  VALUES (?,?)";

    // //echo gettype($phone)."\n";
    // //echo  $phone;

    // if($stmt = mysqli_prepare($link, $sql)){
    //     // Bind variables to the prepared statement as parameters
    //     mysqli_stmt_bind_param($stmt, "ss", $user_id, $phone);
        
    //     // Set parameters
    //     $param_user_id = $user_id;
    //     $param_phone = $phone;
        
    //     // Attempt to execute the prepared statement
    //     if(mysqli_stmt_execute($stmt)){
    //         // Redirect to login page
    //         #header("location: login.php");
    //     } else{
    //         echo $stmt->error;
    //         echo "Oops! Something went wrong. Please try again later.";
    //     }

    //     // Close statement
    //     mysqli_stmt_close($stmt);
    // }

    // //Adding user gender to user_gender

    // $em = "SELECT user_id FROM users WHERE username = '$username'";
    // $q = mysqli_query($link,$em);
    // $n = mysqli_fetch_array($q);
    // $id = intval($n['user_id']);
    // $gender = trim($_POST["gender"]);
    // $sql = "UPDATE user_gender SET gender= (?) WHERE user_id = '$user_id'";

    // //echo gettype($phone)."\n";
    // //echo  $phone;

    // if($stmt = mysqli_prepare($link, $sql)){
    //     // Bind variables to the prepared statement as parameters
    //     mysqli_stmt_bind_param($stmt, "s" ,$gender);
        
    //     // Set parameters

    //     $param_gender = $gender;
        
    //     // Attempt to execute the prepared statement
    //     if(mysqli_stmt_execute($stmt)){
    //         // Redirect to login page
    //         #header("location: login.php");
    //     } else{
    //         echo $stmt->error;
    //         echo "Oops! Something went wrong. Please try again later.";
    //     }

    //     // Close statement
    //     mysqli_stmt_close($stmt);
    // }
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
    <?php include('header.html') ?>

    <?php
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


    ?>

    <br></br>
    <div class="wrapper" style="width:600px;margin:0 auto;">
        <h2 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. This is your Account Page</h2>

        <div class="list-group w-auto">
            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">First Name</h6>
                        <?php echo $row1['first_name']; ?>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">

                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">Last Name</h6>
                        <?php echo $row1['last_name']; ?>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">

                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">Address</h6>
                        <?php echo $row1['address']; ?>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">Email</h6>
                        <?php echo $row2['email']; ?>
                    </div>
                </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">

                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">Gender</h6>
                        <?php echo $row3['gender']; ?>
                    </div>
                </div>
            </a>
            <?php while ($row4 = mysqli_fetch_array($rs_result4)) { ?>
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Phone</h6>
                            <?php echo $row4['phone']; ?>
                        </div>
                    </div>
                </a>
            <?php }; ?>
        </div>
        <br></br>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 
        <div class="form-group">
            <label>Gender</label>
            <input type="text" name="gender" class="form-control ">
            <span class="invalid-feedback"></span>
        </div> 
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <a href="welcome.php"class="btn btn-primary">Go back to Home Page</a>

    </div>


    <br></br>
    <br></br>
    <br></br>
        
    
</body>

</html>