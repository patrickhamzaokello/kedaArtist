<?php


// reset all songs played after 6 hours
// $resetWEEKPlays = mysqli_query($con, "UPDATE songs SET weekplays=0 WHERE  lastplayed < DATE_ADD(NOW(), INTERVAL -6 DAY)");

// reset all songs played after a week
$resetWEEKPlays = mysqli_query($con, "UPDATE songs SET weekplays=0 WHERE  lastplayed < DATE_ADD(NOW(), INTERVAL -7 DAY)");

$topchart = mysqli_query($con, "SELECT id FROM songs WHERE tag='music' ORDER BY weekplays DESC LIMIT 10");

$topSongsArray = array();


while ($row = mysqli_fetch_array($topchart)) {

  array_push($topSongsArray, $row['id']);
}