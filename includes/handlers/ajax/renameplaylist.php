<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

if(! isset($_POST['userLoggedIn'])){
    echo "Error: could not set username";
    exit();
}

if(isset($_POST['newname']) && $_POST['playlistId'] !="" ){
    

    $name = $_POST['newname'];
    $playlistID = $_POST['playlistId'];
    $username = $_POST['userLoggedIn'];

    // if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //     echo "Email is invalid";
    //     exit();
    // }


    $updateQuery = mysqli_query($con, "UPDATE playlists SET name = '$name' WHERE id='$playlistID'");

   
}

else{
    echo "You must provide playlist new name";
}