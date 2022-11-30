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




    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $delete_id = $_POST['delete'];


        $sql = "SET FOREIGN_KEY_CHECKS=0;";
        $result = mysqli_query($link, $sql);
        if ($stmt = mysqli_prepare($link, "DELETE FROM vehicle WHERE car_id = '$delete_id';")) {

            mysqli_stmt_bind_param($stmt, "i", $delete_id);

            // Set parameters
            $param_delete_id = $delete_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo $stmt->error;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo mysqli_error($link);
            echo "error occured";
        }

        // Close statement
        // mysqli_stmt_close($stmt);
    }

    $query_selling_cars = "SELECT car_id FROM vehicle WHERE user_id = '$user_id'";
    $list_of_selling_Cars = mysqli_query($link, $query_selling_cars);
    $selling_car = mysqli_fetch_array($list_of_selling_Cars);

    ?>

    <br></br>
    <div class="wrapper" style="width:600px;margin:0 auto;">
        <?php include('header.html') ?>
        <h2 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Here are all your cars:</h2>

        <div class="list-group w-auto">

            <?php if (is_null($selling_car)) { ?>
                <a class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <?php echo "None"; ?>

                        </div>
                    </div>
                </a>

            <?php } else { ?>
                <a class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <?php echo $selling_car['car_id']; ?>
                        </div>
                    </div>
                </a>
                <?php while ($selling_car = mysqli_fetch_array($list_of_selling_Cars)) { ?>
                    <a class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <?php echo $selling_car['car_id']; ?>
                            </div>
                        </div>
                    </a>
                <?php }; ?>
            <?php
            } ?>

        </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
        <form method="POST">

            <div class="form-group">
                <h5>Please Type the Car ID to Delete</h5>
                <input type="number" name="delete" class="form-control ">
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>

    </div>


    <br></br>
    <br></br>
    <br></br>
    <?php include('footer.html') ?>

</body>

</html>