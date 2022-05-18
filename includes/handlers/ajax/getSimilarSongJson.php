<?php

require("../../config.php");
$db = new Database();
$con = $db->getConnString();

if (isset($_POST['songId'])) {

    $songId = $_POST['songId'];

    $similarSongIds = array(); 

    $query = mysqli_query($con, "SELECT * FROM ( SELECT * FROM songs WHERE genre = (SELECT genre from songs where id='$songId') ORDER BY RAND() LIMIT 10) AS mix ORDER BY plays DESC");

    while ($resultArray = mysqli_fetch_array($query)) {

        array_push($similarSongIds, $resultArray['id']);
    
    }

    echo json_encode($similarSongIds);
}