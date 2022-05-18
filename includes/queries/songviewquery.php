<?php

//songs ids
$songIdArray = array();
$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE artist = '$songartistid' AND id != '$songid' ORDER BY weekplays DESC LIMIT 5");
while ($row = mysqli_fetch_array($songsQuery)) {
    array_push($songIdArray, $row['id']);
}


$similarSongarray = array();
$simsongsQuery = mysqli_query($con, "SELECT id FROM songs WHERE genre = '$songGenreid' AND id != '$songid' AND artist != '$songartistid' ORDER BY weekplays DESC LIMIT 5");
while ($row = mysqli_fetch_array($simsongsQuery)) {
    array_push($similarSongarray, $row['id']);
}