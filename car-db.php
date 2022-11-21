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

function removeLike($car_id, $user_id)
{
  global $link;
  $sql = "DELETE FROM `likecar` WHERE `likecar`.`user_id` = ? AND `likecar`.`car_id` = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $car_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function getAllLikedCars($user_id)
{
  global $link;
  $sql = "SELECT car_id FROM likecar WHERE user_id = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $rowResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);
  return $rowResult;
}

function getAllSeller()
{
  global $link;
  $sql = "SELECT * FROM seller";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $rowResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);
  return $rowResult;
}
function getAllSellers()
{
  global $link;
  $sql = "SELECT * FROM seller";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $rowResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);
  return $rowResult;
}

function getCarDetails($car_id)
{
  global $link;
  $stmt = $link->prepare("SELECT * FROM vehicle WHERE car_id = ?");
  $stmt->bind_param("s", $car_id);
  $stmt->execute();
  $arr = $stmt->get_result()->fetch_assoc();
  if (!$arr) exit('No rows');
  $stmt->close();
  return $arr;
}
function insertNewFinance($user_id, $amount, $finance_length, $interest_rate, $start_date)
{
  global $link;
  $sql = "INSERT INTO finance_transaction(user_id, amount, finance_length, interest_rate, start_date) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "iiids", $user_id, $amount, $finance_length, $interest_rate, $start_date);
  mysqli_stmt_execute($stmt);
  $error_msg =  $stmt->error;
  mysqli_stmt_close($stmt);
  return $error_msg;
}

