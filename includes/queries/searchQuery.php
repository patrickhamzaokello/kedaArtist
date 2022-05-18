<?php

//songs ids
$songIdArray = array();
$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%'  AND tag ='music' LIMIT 10");
while ($row = mysqli_fetch_array($songsQuery)) {
    array_push($songIdArray, $row['id']);
}

//artist ids
$searchartistarray = array();
$artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '%$term%' LIMIT 10");
while ($row = mysqli_fetch_array($artistQuery)) {
    array_push($searchartistarray, $row['id']);
} 

// albums id
$albumSearchArray = array();
$albumQuery = mysqli_query($con, "SELECT id FROM albums where title LIKE '%$term%' and tag !='ad' LIMIT 10");
while ($row = mysqli_fetch_array($albumQuery)) {
    array_push($albumSearchArray, $row['id']);
}


//podcast
$podcastsearchQueryhArray = array();
$podsongsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' AND tag ='podcast' LIMIT 10");
while ($row = mysqli_fetch_array($podsongsQuery)) {
    array_push($podcastsearchQueryhArray, $row['id']);
}


//poames ids
$poemsearchQueryhArray = array();
$poemsearchQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' AND tag ='poem' LIMIT 10");
while ($row = mysqli_fetch_array($poemsearchQuery)) {
    array_push($poemsearchQueryhArray, $row['id']);
}


//dj mixtapes
$djsearchQueryArray = array();
$djsearchQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' AND tag ='dj' LIMIT 10");
while ($row = mysqli_fetch_array($djsearchQuery)) {
    array_push($djsearchQueryArray, $row['id']);
}
