<?php
// Initialize the session
session_start();
require("car-db.php");
require("config.php");
$list_of_cars = getAllCars();
$list_of_liked_Cars = getAllLikedCars($_SESSION["user_id"]);
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'liked') {
        echo $_POST['car_to_like'];
        addLike($_POST['car_to_like'], $_SESSION["user_id"]);
        $list_of_liked_Cars = getAllLikedCars($_SESSION["user_id"]);
    } elseif (isset($_POST['car_id']) && $_POST['to_like'] == 1) {
        addLike($_POST["car_id"], $_SESSION["user_id"]);
        die();
    } elseif (isset($_POST['car_id']) && $_POST['to_like'] == 0) {
        removeLIke($_POST["car_id"], $_SESSION["user_id"]);
        die();
    }
}
$raw_results = Null;
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
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to CARHUGE</h1>
    <form method="POST">
        <div class="wrapper" style="width:600px;margin:0 auto;">
            <div class="d-flex" role="search">
                <input class="form-control me-2" name="year" placeholder="Search by Year" aria-label="Search">
                <input class="btn btn-outline-success" type="submit" value="Search"></button>
            </div>
        </div>
    </form>
    </br>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = $_POST['year'];
        $min_length = 0;
        if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

            $query = htmlspecialchars($query);
            $q = "SELECT * FROM vehicle WHERE (year= '$query') ;";
            $raw_results = mysqli_query($link, $q);
            // * means that it selects all fields, you can also write: `id`, `title`, `text`
            // articles is the name of our table

            // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
            // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
            // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

            if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following
                while ($row = mysqli_fetch_array($raw_results)) { ?>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="col">

                                <div class="card shadow-sm">
                                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                                        <title>Placeholder</title>
                                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                                    </svg>
                                    <div class="card-body">
                                        <h2 class="card-text">
                                            <?php echo $row['make']; ?>
                                            <?php echo $row['year']; ?>
                                            <?php echo $row['model']; ?>
                                        </h2>

                                        <?php
                                        $like_btn_color = "#FFFFFF";
                                        $like_btn_class = "";
                                        foreach ($list_of_liked_Cars as $curCar) :
                                            if ($curCar['car_id'] == $row['car_id']) {
                                                $like_btn_color = "red";
                                                $like_btn_class = "liked";
                                            }
                                        endforeach;
                                        ?>

                                        <!-- like button on each car post -->
                                        <button id=<?php echo $row['car_id']; ?> class=<?php echo $like_btn_class; ?> style="background-color:<?php echo $like_btn_color; ?>;">Like</button>

                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

                                        <script>
                                            // get the button using id which is the car_id
                                            $("#<?php echo $row['car_id']; ?>").click(function(e) {
                                                if ($(this).hasClass("liked")) {
                                                    $(this).removeClass("liked");
                                                    document.getElementById(<?php echo $row['car_id']; ?>).style.background = "#FFFFFF";
                                                    $.post("welcome.php", {
                                                        "to_like": 0,
                                                        "car_id": <?php echo $row['car_id']; ?>
                                                    });
                                                } else {
                                                    $(this).addClass("liked");
                                                    // change appearance of button 
                                                    document.getElementById(<?php echo $row['car_id']; ?>).style.background = "red";
                                                    // send post to php to modify database    
                                                    $.post("welcome.php", {
                                                        "to_like": 1,
                                                        "car_id": <?php echo $row['car_id']; ?>
                                                    });
                                                }
                                            });
                                        </script>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">


                                                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">View</button> -->
                                                <!-- <button type="submit" value = "liked" name="btnAction" class="btn btn-sm btn-outline-secondary">Like</button> -->
                                                <a href="view.php?car_id=<?php echo $row['car_id']; ?>"><button type="button" class="btn btn-sm btn-outline-secondary">View</button></a>
                                                <input type="hidden" name="car_to_like" value="<?php echo $row['car_id']; ?>" />

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
    <?php };
            } else { // if there is no matching rows do following
                echo "No results";
            }
        } else { // if query length is less than minimum
            echo "Minimum length is " . $min_length;
        }
    } else {
        $raw_results = getAllCars();
    }


    ?>


    </br>
    </br>

    <?php include('footer.html') ?>
</body>

</html>