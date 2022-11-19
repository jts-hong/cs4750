<?php

function getAllCars()
{
    global $link;
    $result = mysqli_query($link, "SELECT * FROM vehicle");
    return $result;
}

function addLike($car_id, $user_id)
{
  global $link;
  $sql = "INSERT INTO likecar VALUES(?, ?)";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $car_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

}

function getAllLikedCars()
{
    global $link;
    $result = mysqli_query($link, "SELECT * FROM vehicle");
    return $result;
}



?>
