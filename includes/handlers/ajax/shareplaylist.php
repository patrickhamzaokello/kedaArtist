<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if (isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];
    $userLoggedIn = $_POST['userLoggedIn'];
    $tag = $_POST['sharetag'];
    $featuredplaylist = 'yes';


    /***
     * determines if playlist is shared with friends only or public
     * 1- publick
     * 2- friends only
     */
    $updateplayliststatus = mysqli_query($con, "UPDATE playlists SET status=$tag, featuredplaylist='$featuredplaylist' WHERE id='$playlistId' AND owner='$userLoggedIn'");
} else {
    echo "Variables  not passed into shareplaylist.php";
    exit;
}