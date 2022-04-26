<?php
include("../config/database.php");

if (isset($_POST['songtitle']) && isset($_POST['albumID']) && isset($_POST['songId'])) {
    $songtitle = $_POST['songtitle'];
    $albumID = $_POST['albumID'];
    $songId = $_POST['songId'];


    $albumCheck = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumID'");
    if (mysqli_num_rows($albumCheck) != 1) {
        echo "Album Doesn't Exist";
        exit();
    }



    if (preg_match('/[^A-Za-z0-9_ -]/', $songtitle)) {
        echo "Your Album name must only contain letters and/or numbers";
        exit();
    }

    if (strlen($songtitle) > 30 || strlen($songtitle) < 1) {
        echo "Your Album name must be between 1 and 30 characters";
        exit();
    }

    $query = mysqli_query($con, "UPDATE songs SET title='$songtitle' WHERE id='$songId'");
    // echo "Update successful";
} else {
    if (!isset($_POST['songId'])) {
        echo "ERROR: Could not set songId";
        exit();
    }

    if (!isset($_POST['songtitle'])) {
        echo "Songtile have not been set";
        exit();
    }

    if (!isset($_POST['albumID'])) {
        echo "albumID have not been set";
        exit();
    }

    if ($_POST['songtitle'] == "") {
        echo "Please fill in all fields";
        exit();
    }

    echo "update failed";
}