<?php
// Initialize the session
session_start();
require("car-db.php");
require("config.php");
$list_of_cars = getAllCars();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'liked')
  {
    echo $_POST['car_to_like'];
    addLike($_POST['car_to_like'], $_SESSION["user_id"]);
  }
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
    <?php include('header.html') ?>
    <br></br>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["user_id"]); ?></b>. Welcome to CARHUGE</h1>

    <?php
    $per_page_record = 10;  // Number of entries to show in a page.   
    if (isset($_GET["page"])) {
        $page  = $_GET["page"];
    } else {
        $page = 1;
    }


    $start_from = ($page - 1) * $per_page_record;

    $query = "SELECT * FROM vehicle  LIMIT $start_from, $per_page_record";
    $rs_result = mysqli_query($link, $query);
    ?>


    <?php while ($row = mysqli_fetch_array($rs_result)) { ?>
        <div class="album py-5 bg-light">
            <div class="container">

                    <div class="col">
                        <div class="card shadow-sm">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                            <div class="card-body">
                                <p class="card-text">
                                    <?php echo $row['make']; ?>
                                    <?php echo $row['car_id']; ?>
                                    <?php echo $row['model']; ?>
                                </p>
                                <form action="welcome.php" method="post">
                                  <div class="d-flex justify-content-between align-items-center">
                                      <div class="btn-group">
                                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                          <button type="submit" value = "liked" name="btnAction" class="btn btn-sm btn-outline-secondary">Like</button>
                                          <input type="hidden" name="car_to_like" value="<?php echo $row['car_id']; ?>"/>
                                      </div>
                                      <small class="text-muted">9 mins</small>
                                  </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php }; ?>
    <?php
    $query = "SELECT COUNT(*) FROM vehicle";
    $rs_result = mysqli_query($link, $query);
    $row = mysqli_fetch_row($rs_result);
    $total_records = $row[0];
    echo "</br>";
    // Number of pages required.   
    $total_pages = ceil($total_records / $per_page_record);
    $pagLink = "";
    if ($page >= 2) {
        echo "<a class='btn btn-outline-primary' href='welcome.php?page=" . ($page - 1) . "'>  Prev </a>";
    }
    echo $pagLink;
    if ($page < $total_pages) {
        echo "<a class='btn btn-outline-primary' href='welcome.php?page=" . ($page + 1) . "'>  Next </a>";
    }
    ?>
    <input id="page" type="number" min="1" max="<?php echo $total_pages ?>" placeholder="<?php echo $page . "/" . $total_pages; ?>" required>
    <button onClick="go2Page();" class="btn btn-primary">Go</button>
    <script>
        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page > <?php echo $total_pages; ?>) ? <?php echo $total_pages; ?> : ((page < 1) ? 1 : page));
            window.location.href = 'welcome.php?page=' + page;
        }
    </script>
    <br></br>
    <br></br>
    <br></br>
    <?php include('footer.html') ?>
</body>

</html>
