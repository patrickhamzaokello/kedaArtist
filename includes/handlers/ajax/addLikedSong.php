<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(isset($_POST['songId']) && isset($_POST['artistId']) && isset($_POST['username'])) {

	$songId = $_POST['songId'];
	$artistId = $_POST['artistId'];
	$username = $_POST['username'];
	$currentuser = $_POST['currentuser'];

	// $checkifsongexits = mysqli_query($con, "SELECT songId,artistId FROM likedsongs WHERE userID ='$currentuser'");

	//song exits
	
	$orderIdQuery = mysqli_query($con, "SELECT IFNULL(max(songorder)+1, 1) AS songorder FROM likedsongs WHERE userID ='$currentuser'");
	
	$row = mysqli_fetch_array($orderIdQuery);

	$order = $row['songorder'];

	$query = mysqli_query($con, "INSERT INTO likedsongs (`songId`,`artistId`,`songorder`,`userID`) VALUES('$songId','$artistId','$order','$currentuser')");



	//get songurl
	$songpath_query = mysqli_query($con, "SELECT path FROM songs WHERE id ='$songId'");
	
	$songrow = mysqli_fetch_array($songpath_query);


	if($songrow != null){
		echo json_encode($songrow);
	}



}
else {
	echo "Song Id not specified by user";
}