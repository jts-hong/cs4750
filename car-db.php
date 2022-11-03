<?php

function getAllCars()
{
    global $link; 
    $result = mysqli_query($link, "SELECT * FROM vehicle");
    return $result;
}
 





?>