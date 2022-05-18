<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if (isset($_POST['userID']) && isset($_POST['friendID'])) {

    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $friendID = $_POST['friendID'];
    $otheruserName = $_POST['otheruserName'];
    $tag =  $_POST['tag'];

    if ($tag == 0) {
        $query = mysqli_query($con, "INSERT INTO friends (followee, username, follower, followerName) VALUES ('$userID','$userName', '$friendID','$otheruserName')");
        exit;
    } else if ($tag == 1) {
        $query = mysqli_query($con, "DELETE FROM friends WHERE followee = '$userID' AND follower= '$friendID'");
        exit;
    }
} else {
    echo "Error Executing the Query";
}