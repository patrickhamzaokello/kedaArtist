<?php
require "../config.php";

$db = new Database();
$con = $db->getConnString();

if (isset($_POST['creator'])) {

	$name = "Mwonyaa";
	$username = $_POST['creator'];
	$userid = $_POST['creator'];

    $firstthreeletters = substr($userid, 0,5);
    $plid = "mwPL".uniqid().$firstthreeletters;

	$query = mysqli_query($con, "INSERT INTO playlists(id,name,owner,ownerID) VALUES('$plid','$name','$username','$userid')");
} else {
	echo "Name or username parameters not passed into file";
	exit;
}