<?php
require "config.php";
require "classes/User.php";
// require "classes/Artist.php";
// require "classes/Album.php";
// require "classes/Song.php";
if (isset($_GET['id'])) {
    $artistId =  $_GET['id'];
} else {
      header("Location:index");
}

$db = new Database();
$con = $db->getConnString();


$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
$username = $userLoggedIn->getUsername();
$userId = $userLoggedIn->getUserId();



$followingquery = mysqli_query($con, "SELECT * FROM artistfollowing WHERE artistid='$artistId' AND userid='$userId'");
if (mysqli_num_rows($followingquery) == 0) {
    echo "<button id='MyButton' class='button-light followbutton' onclick='followArtist(\"".$artistId."\",\"".$userId."\",0)'>Follow</button>";
} else {
    echo "<button id='MyButton' class='button-light unfollowbutton' onclick='followArtist(\"".$artistId."\",\"".$userId."\",1)'>UnFollow</button>";
}



?>