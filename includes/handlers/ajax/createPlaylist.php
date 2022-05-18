<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$target_dir  = '../../../assets/images/createdplaylist/';
$db_target_dir  = 'assets/images/createdplaylist/';


if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['userId'])) {

	$name = $_POST['name'];

	$formatedname = $name.strip_tags($name);
	$formatedname = str_replace(" ", "_",$formatedname);
	$username = $_POST['username'];
	$userid = $_POST['userId'];
	$plDEsc = $_POST['playlistdescription'];

	$firstthreeletters = substr($userid, 0, 5);
	$plid = "mwPL" . uniqid() . $firstthreeletters;

	$temp = explode(".", $_FILES["inputfile"]["name"]);

    $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
    $newfilename = stripslashes( $formatedname .'_' .$userid.'_playlist') . $postfix . '.' . end($temp);

	$targetPath = $target_dir . basename($newfilename);
	$db_targetPath = $db_target_dir . basename($newfilename);

	if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
		$query = mysqli_query($con, "INSERT INTO playlists(id,name,owner,ownerID,description,coverurl) VALUES('$plid','$name','$username','$userid','$plDEsc','$db_targetPath')");
		echo $plid;
	} else {
		echo "error";
	}

} else {
	return false;
}
