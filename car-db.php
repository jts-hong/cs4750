<?php

function getAllCars()
{
    global $link; 
    $sql = "SELECT * FROM vehicle";
    $result = mysqli_query($link, "SELECT * FROM vehicle");

    return $result;
}
 ?>