<?php
include("../config/database.php");

if (!isset($_POST['username'])) {
    echo "ERROR: Could not set username";
    exit();
}

if (!isset($_POST['name'])) {
    echo "Name have not been set";
    exit();
}

if (!isset($_POST['albumID'])) {
    echo "albumID have not been set";
    exit();
}

if ($_POST['name'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$albumname = $_POST['name'];
$albumID = $_POST['albumID'];



$albumCheck = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumID'");
if (mysqli_num_rows($albumCheck) != 1) {
    echo "Album Doesn't Exist";
    exit();
}



if (preg_match('/[^A-Za-z0-9_ -]/', $albumname)) {
    echo "Your Album name must only contain letters and/or numbers";
    exit();
}

if (strlen($albumname) > 30 || strlen($albumname) < 1) {
    echo "Your Album name must be between 1 and 30 characters";
    exit();
}


$query = mysqli_query($con, "UPDATE albums SET title='$albumname' WHERE id='$albumID'");
// echo "Update successful";