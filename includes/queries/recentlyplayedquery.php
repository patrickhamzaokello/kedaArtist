<?php

$userId = $userLoggedIn->getUserId();

$recentSongIds = array();


$recentlyPlayedsongs = mysqli_query($con, "SELECT  songid FROM frequency WHERE userid='$userId' AND tag = 'music'  ORDER BY dateAdded DESC LIMIT 20");
while ($row = mysqli_fetch_array($recentlyPlayedsongs)) {

    array_push($recentSongIds, $row['songid']);

}



?>