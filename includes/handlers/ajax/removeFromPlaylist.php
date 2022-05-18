<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];
    

	$query = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId='$playlistId' AND songId = '$songId' ");
}
else {
	echo "PlaylistId or SongId was not passed into removeFromPlaylist.php";
}