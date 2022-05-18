<?php

require("../../config.php");
$db = new Database();
$con = $db->getConnString();

if (isset($_POST['songId'])) {

    $songId = $_POST['songId'];

    $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray);
}