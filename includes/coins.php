<?php
require "config.php";
require "classes/User.php";
require "classes/Artist.php";
require "classes/Album.php";
require "classes/Song.php";
include("classes/Playlist.php");


$db = new Database();
$con = $db->getConnString();

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($con,  $_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getUsername();
    $userId = $userLoggedIn->getUserId();

    echo "<script>userLoggedIn = '$username';</script>";
} else {
    header("Location: register");
}


$coins = $userLoggedIn->getPoints();


//disable play if coins is less than 1
if ($coins < 1) {
    echo "
    <script>
        coins = false;
    </script>
    ";
}



echo "

Rewards: $coins

";