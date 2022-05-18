<?php

require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['albumId'])){

    $albumId = $_POST['albumId'];

    $query = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");

    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray); 

}