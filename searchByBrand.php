<?php
// Initialize the session
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

<?php

    $query = $_POST['make'];
    $min_length = 3;
    if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

        $query = htmlspecialchars($query);
        $q = "SELECT * FROM vehicle WHERE (make LIKE '%$query%') ;";
        $raw_results = mysqli_query($link, $q);
        // * means that it selects all fields, you can also write: `id`, `title`, `text`
        // articles is the name of our table

        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

        if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following

        } else { // if there is no matching rows do following
            echo "No results";
        }
    } else { // if query length is less than minimum
        echo "Minimum length is " . $min_length;
    }
    ?>
    <?php include('header.html') ?>
    <br></br>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to CARHUGE</h1>
    <form method="POST">
        <div class="wrapper" style="width:600px;margin:0 auto;">
            <div class="d-flex" role="search">
                <input class="form-control me-2" name="make" placeholder="Search by Make" aria-label="Search">
                <input class="btn btn-outline-success" type="submit" value="Search"></button>
            </div>
        </div>
    </form>
    </br>
    <?php while ($row = mysqli_fetch_array($raw_results)) { ?>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="col">
                    <div class="card shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                        <div class="card-body">
                            <p class="card-text">
                                <?php echo $row['make']; ?>
                                <?php echo $row['year']; ?>
                                <?php echo $row['model']; ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Like</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php }; ?>

    </br>
    </br>

    <?php include('footer.html') ?>
</body>

</html>