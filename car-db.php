<?php
require_once "config.php";
function getAllCars()
{
    global $link; 
    $query = "SELECT * FROM cars";
    $statement = $link->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}
// ?>