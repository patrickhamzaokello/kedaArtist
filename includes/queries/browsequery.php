<?php


$publicplaylistsarray = array();
$curatedplaylist = array();
$featuredartists = array();
$albumsarray = array();
$podcastsarray = array();
$poemsarray = array();
$djmixesarray = array();



// query all playlists whose status is 1  that is public state
$playlistQuery = mysqli_query($con, "SELECT * FROM playlists where status = 1 AND featuredplaylist ='yes' ORDER BY RAND ()");
//query all curated playlist whose expirystate is false (0) - not expired yet
$curatedplaylistQuery = mysqli_query($con, "SELECT * FROM curatedplaylist where expirystate = 0");
$musicartistQuery = mysqli_query($con, "SELECT * FROM artists WHERE tag='music' ORDER BY overalplays DESC LIMIT 20");
$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE tag = \"music\" ORDER BY totalsongplays DESC LIMIT  20");
$podcastQuery = mysqli_query($con, "SELECT * FROM albums WHERE tag = \"podcast\" ORDER BY datecreated DESC LIMIT 20");
$poemQuery = mysqli_query($con, "SELECT * FROM albums WHERE tag = \"poem\" ORDER BY datecreated DESC LIMIT 20");
$djQuery = mysqli_query($con, "SELECT * FROM albums WHERE tag = \"dj\" ORDER BY datecreated DESC LIMIT 20");


//pushing to publicplaylist array
while ($row = mysqli_fetch_array($playlistQuery)) {

    array_push($publicplaylistsarray, $row);
}

//pushing to curatedplaylist array
while ($row = mysqli_fetch_array($curatedplaylistQuery)) {

    array_push($curatedplaylist, $row);
}

//pushing to featuredartists array
while ($row = mysqli_fetch_array($musicartistQuery)) {

    array_push($featuredartists, $row);
}


//pushing to the album array
while ($row = mysqli_fetch_array($albumQuery)) {

    array_push($albumsarray, $row);
}

//pushing to the podcast array
while ($row = mysqli_fetch_array($podcastQuery)) {

    array_push($podcastsarray, $row);
}


//pushing to the poem array
while ($row = mysqli_fetch_array($poemQuery)) {

    array_push($poemsarray, $row);
}


//pushing to the djmix array
while ($row = mysqli_fetch_array($djQuery)) {

    array_push($djmixesarray, $row);
}