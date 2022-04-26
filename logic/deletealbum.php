<?php
include("../config/database.php");


if (isset($_POST['albumID']) && isset($_POST['artworkPath']) && isset($_POST['username'])) {
    $albumid = $_POST['albumID'];
    $artworkPath = $_POST['artworkPath'];
    $username = $_POST['username'];





    $query = mysqli_query($con, "DELETE FROM songs WHERE album='$albumid'");
    $query = mysqli_query($con, "DELETE FROM albums WHERE id='$albumid'");

    unlink('../../' . $artworkPath);


    // $query = mysqli_query($con, "DELETE FROM albums WHERE id='$albumid' AND songId = '$songId' ");

} else {
    echo "Album ID  or Username was not passed into DeleteAlbum";
}