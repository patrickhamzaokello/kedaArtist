<?php
require "config.php";
require "classes/User.php";
// require "classes/Artist.php";
// require "classes/Album.php";
// require "classes/Song.php";
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




$username = $userLoggedIn->getUsername();

$playlistQuery = mysqli_query($con, "SELECT * FROM playlists where owner ='$username' ORDER BY dateCreated DESC");

if (mysqli_num_rows($playlistQuery) == 0) {
  echo "<span class='navigation__list__item'>No Playlist Created</span>";
}

while ($row = mysqli_fetch_array($playlistQuery)) {

  $playlist = new Playlist($con, $row);

  echo "
<span href='#' class='navigation__list__item' role='link' tabindex='0'
    onclick='openPage(\"playlist?id=" . $playlist->getId() . "\")'>
    <i class='ion-ios-musical-notes'></i>
    <span>" . $playlist->getName() . "</span>
</span>";
}