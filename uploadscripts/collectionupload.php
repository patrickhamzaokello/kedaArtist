<?php

// Database connection
include("config/database.php");

function sanitizeFormUsername($inputText)
{
    $inputText = strip_tags($inputText);
    return $inputText;
}


// //Our select statement. This will retrieve the data that we want.
// $sqlartist = "SELECT id, name FROM artists";
$sqlgenre = "SELECT id, name FROM genres where tag='music' ORDER BY `genres`.`name` ASC";


// //Prepare the select statement.
// $stmtartist = $conn->prepare($sqlartist);
$stmtgrenre = $conn->prepare($sqlgenre);

// //Execute the statement.
// $stmtartist->execute();
$stmtgrenre->execute();

// //Retrieve the rows using fetchAll.
// $artists = $stmtartist->fetchAll();
$genres = $stmtgrenre->fetchAll();

if (isset($_POST["submit"])) {

    $selectArtist =  $artistid;
    $selectGenre = $artistgenre;
    $albumtitle = sanitizeFormUsername($_POST['AlbumTitle']);
    $contenttype = sanitizeFormUsername($_POST['contenttype']);
    $description = sanitizeFormUsername($_POST['description']);

    $firstthreeletters = substr(rand(), 0, 3);
    $id = "m_al" . uniqid() . $firstthreeletters;


    if ($contenttype == 'music') {
        $target_dir = "../assets/images/artwork/";
        $dbtarget_dir = "assets/images/artwork/";
    } elseif ($contenttype == 'podcast') {
        $target_dir = "../assets/images/podcastalbumartwork/";
        $dbtarget_dir = "assets/images/podcastalbumartwork/";
    } elseif ($contenttype == 'dj') {
        $target_dir = "../assets/images/podcastalbumartwork/";
        $dbtarget_dir = "assets/images/podcastalbumartwork/";
    } elseif ($contenttype == 'poem') {
        $target_dir = "../assets/images/poemsartwork/";
        $dbtarget_dir = "assets/images/poemsartwork/";
    } else {
        echo "Media Tag is Not Provided";
        return;
    }

    $temp = explode(".", $_FILES["fileUpload"]["name"]);
    // $newfilename = round(microtime(true)) . '.ll' . end($temp);

    $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
    $newfilename = stripslashes($contenttype) . $postfix . '.' . end($temp);


    // $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    // $dbtarget_file = $dbtarget_dir . basename($_FILES["fileUpload"]["name"]);

    $target_file = $target_dir . basename($newfilename);
    $dbtarget_file = $dbtarget_dir . basename($newfilename);



    // Get file extension
    $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Allowed file types
    $allowd_file_ext = array("jpg", "jpeg", "png");


    if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "Select image to upload."
        );
    } else if (!in_array($imageExt, $allowd_file_ext)) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "Allowed file formats .jpg, .jpeg and .png."
        );
    } else if ($_FILES["fileUpload"]["size"] > 80097152) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "File is too large. File size should be less than 2 megabytes."
        );
    } else if (file_exists($target_file)) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "File already exists."
        );
    } else {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
            // $mysqldate = date("Y-m-d H:i:s");

            $sql = "INSERT INTO albums (id,title,artist,genre,artworkPath,tag,description) VALUES ('$id','$albumtitle','$selectArtist','$selectGenre','$dbtarget_file','$contenttype','$description')";

            // $updatesql = mysqli_query($conn,"UPDATE artists SET lastupdate='$mysqldate' WHERE id ='$selectArtist'");

            $stmt = $conn->prepare($sql);
            if ($stmt->execute()) {
                $resMessage = array(
                    "status" => "alert-success",
                    "message" => "Image uploaded successfully."
                );

                header("Location:uploadmedia");
            }
        } else {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "Image coudn't be uploaded."
            );
        }
    }
}