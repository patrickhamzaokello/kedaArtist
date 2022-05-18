<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];
    

    $orderIdQuery = mysqli_query($con, "SELECT IFNULL(max(playlistOrder)+1, 1) AS playlistOrder FROM playlistsongs WHERE playlistId ='$playlistId'");
    
    $row = mysqli_fetch_array($orderIdQuery);

    $order = $row['playlistOrder'];

    $query = mysqli_query($con, "INSERT INTO playlistsongs (`songId`,`playlistId`,`playlistOrder`) VALUES('$songId','$playlistId','$order')");
}
else {
	echo "PlaylistId or SongId was not passed into addToPlaylist.php";
}