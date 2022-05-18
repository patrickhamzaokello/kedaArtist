<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$filebase = '../../../';

if (isset($_POST['playlistId'])) {
	$playlistId = $_POST['playlistId'];

	$plquery = mysqli_query($con, "SELECT * FROM playlists WHERE id='$playlistId' LIMIT 1");
	$plrow = mysqli_fetch_array($plquery);

	$plrowpath =  $plrow['coverurl'];

	$playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId'");
	$songsQuery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId='$playlistId'");

	if ($plrow) {
		unlink($filebase .$plrowpath);

	} else {
		return false;
	}
} else {
	echo "PlaylistId was not passed into deletePlaylist.php";
}
