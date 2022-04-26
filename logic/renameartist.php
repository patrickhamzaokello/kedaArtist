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

if (!isset($_POST['artistID'])) {
    echo "artistID have not been set";
    exit();
}

if ($_POST['name'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$artistnewname = $_POST['name'];
$artistID = $_POST['artistID'];



$artistcheck = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistID'");
if (mysqli_num_rows($artistcheck) != 1) {
    echo "Artist Doesn't Exist";
    exit();
}



if (preg_match('/[^A-Za-z0-9_ -]/', $artistnewname)) {
    echo "Artist name must only contain letters and/or numbers";
    exit();
}

if (strlen($artistnewname) > 30 || strlen($artistnewname) < 1) {
    echo "Artist name must be between 1 and 30 characters";
    exit();
}


$query = mysqli_query($con, "UPDATE artists SET name='$artistnewname' WHERE id='$artistID'");
// echo "Update successful";