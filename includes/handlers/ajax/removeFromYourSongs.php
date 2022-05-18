<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['username']) && isset($_POST['songId'])) {
    $username = $_POST['username'];
	$songId = $_POST['songId'];
    

	$query = mysqli_query($con, "DELETE FROM likedsongs WHERE userID='$username' AND songId ='$songId'");
}
else {
	echo "Username or SongId was not passed into removeFromYourSong.php";
}