<?php

require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['artistId'])){

    $artistId = $_POST['artistId'];

    $query = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");

    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray); 

}


?>