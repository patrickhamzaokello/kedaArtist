<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if (isset($_POST['artistID']) && isset($_POST['userID'])) {

    $artistID = $_POST['artistID'];
    $userID = $_POST['userID'];
    $tag =  $_POST['tag'];

    if ($tag == 0) {
        $query = mysqli_query($con, "INSERT INTO artistfollowing (artistid, userid) VALUES ('$artistID', '$userID')");
        exit;
    } else if ($tag == 1) {
        $query = mysqli_query($con, "DELETE FROM artistfollowing WHERE artistid = '$artistID' AND userid= '$userID'");
        exit;
    }
} else {
    echo "Error Executing the Query";
}