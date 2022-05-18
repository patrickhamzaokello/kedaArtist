<?php

require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if (isset($_POST['songId']) && isset($_POST['userId']) && isset($_POST['userregstatus'])) {

    $songId = $_POST['songId'];
    $userId = $_POST['userId'];
    $userregstatus = $_POST['userregstatus'];

    if ($userregstatus != "registered") {
        $query = mysqli_query($con, "UPDATE songs SET plays = plays +1, weekplays= weekplays+1, lastplayed=(SELECT CURRENT_TIMESTAMP)  WHERE id=$songId");
    } else {
        $pointsquery = mysqli_query($con, "UPDATE users set songsplayed = songsplayed + 1 WHERE id='$userId'");

        $query = mysqli_query($con, "UPDATE songs SET plays = plays +1, weekplays= weekplays+1, lastplayed=(SELECT CURRENT_TIMESTAMP)  WHERE id=$songId");

        //user favourites
        $sql = mysqli_query($con, "SELECT * FROM frequency where  userid='$userId' AND songid=$songId");

        //get media tag
        $mediatag = mysqli_query($con, "SELECT tag FROM songs where id=$songId");
        $mediatagrow = mysqli_fetch_array($mediatag);
        $tagvalue = $mediatagrow['tag'];

        if (mysqli_num_rows($sql) > 0) {
            // echo "song and user Id Already Exists";
            $query = mysqli_query($con, "UPDATE frequency SET playsmonth= playsmonth+1, plays = plays +1,dateAdded=(SELECT CURRENT_TIMESTAMP) WHERE userid='$userId' AND songid=$songId");
            exit;
        } else {
            $query = mysqli_query($con, "INSERT INTO frequency(songid,tag,userid,plays,playsmonth)VALUES($songId,'$tagvalue','$userId',1,1)");
            exit;
        }
    }
} else {
    exit;
}



//recently played for each user
//SELECT * FROM `frequency` WHERE userid=14 ORDER BY dateAdded DESC LIMIT 5
//most played songs
//SELECT * FROM `frequency` WHERE userid=14 ORDER BY plays DESC LIMIT 5