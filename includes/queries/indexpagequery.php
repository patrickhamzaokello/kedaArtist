<?php
$albumsarray = array();

/**
 * ranking artist by week plays
 */
$artistarray = array();

$artistids = mysqli_query($con, "SELECT id from artists");

while ($row = mysqli_fetch_array($artistids)) {
    array_push($artistarray, $row);
}

foreach ($artistarray as $artist) {
    $artistid = $artist['id'];
    // $songplays = mysqli_query($con, "SELECT sum(plays) AS totalPlays from songs where artist ='$artistid'");
    $songplays = mysqli_query($con, "SELECT sum(weekplays) AS totalPlays from songs where artist ='$artistid' AND tag != 'ad'");
    $row = mysqli_fetch_array($songplays);
    $overalltotalplays = $row['totalPlays'];
    $query = mysqli_query($con, "UPDATE artists SET overalplays ='$overalltotalplays' WHERE id='$artistid' ");
}

/**
 * end of ranking artist by week plays
 */

$songartistarray = array();

$songartistids = mysqli_query($con, "SELECT artist from songs");

while ($row = mysqli_fetch_array($songartistids)) {
    array_push($songartistarray, $row);
}

foreach ($songartistarray as $artist) {
    $artistid = $artist['artist'];
    // $songplays = mysqli_query($con, "SELECT sum(plays) AS totalPlays from songs where artist ='$artistid'");
    $songplays = mysqli_query($con, "SELECT id from songs where artist ='$artistid' AND tag != 'ad' Limit 1");

    if (mysqli_num_rows($songplays) == 0) { 
    } else {
        $query = mysqli_query($con, "UPDATE artists SET status = 1 WHERE id='$artistid' ");
    }

}




/**
 * get total  of each album plays
 */

$albumidsarrary = array();
$albumids = mysqli_query($con, "SELECT id from albums");
while ($row = mysqli_fetch_array($albumids)) {
    array_push($albumidsarrary, $row);
}

foreach ($albumidsarrary as $albumidfromarray) {
    $albumidfromarray = $albumidfromarray['id'];
    // $songplays = mysqli_query($con, "SELECT sum(plays) AS totalPlays from songs where artist ='$artistid'");
    $songplays = mysqli_query($con, "SELECT sum(weekplays) AS totalPlays from songs where album ='$albumidfromarray'");
    $row = mysqli_fetch_array($songplays);
    $overalltotalplays = $row['totalPlays'];
    $query = mysqli_query($con, "UPDATE albums SET totalsongplays ='$overalltotalplays' WHERE id='$albumidfromarray' ");
}

/**
 * end of total each album query
 */

$rankedartistarray = array();
$artistrankingids = mysqli_query($con, "SELECT id from artists WHERE tag = \"music\" ORDER BY overalplays DESC LIMIT 6");

while ($row = mysqli_fetch_array($artistrankingids)) {
    array_push($rankedartistarray, $row);
}

foreach ($rankedartistarray as $artistranked) {
    $rankedartistid = $artistranked['id'];
    // query the albums created by ranked artist
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$rankedartistid' ORDER BY datecreated DESC LIMIT 1");
    $row = mysqli_fetch_array($albumQuery);
    array_push($albumsarray, $row);

}
