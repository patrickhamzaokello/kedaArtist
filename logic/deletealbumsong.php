<?php
include("../config/database.php");


if (isset($_POST['songId']) && isset($_POST['albumID']) && isset($_POST['username'])) {
    $songId = $_POST['songId'];
    $albumID = $_POST['albumID'];
    $username = $_POST['username'];

    $query = mysqli_query($con, "DELETE FROM songs WHERE   id='$songId' AND album='$albumID'");
    $query = mysqli_query($con, "DELETE FROM likedsongs WHERE   songId='$songId'");
    $query = mysqli_query($con, "DELETE FROM playlistsongs WHERE   songId='$songId'");
} else {
    echo "Album ID  or Username was not passed into DeleteAlbum";
}