<?php

include("config/database.php");
include("config/MP3File.php");

function sanitizeFormUsername($inputText)
{
    $inputText = strip_tags($inputText);
    return $inputText;
}



if (isset($_POST["mediaArtist"])) {

    $tag = $_POST["mediaTag"];
    $mediaArtist = sanitizeFormUsername($_POST["mediaArtist"]);
    $AlbumTitle = sanitizeFormUsername($_POST["AlbumTitle"]);
    $mediaGenre = sanitizeFormUsername($_POST["mediaGenre"]);
    $mediaDescription = sanitizeFormUsername($_POST["mediaDescription"]);


    $firstthreeletters = substr(rand(), 0, 3);
    $id = "m_al" . uniqid() . $firstthreeletters;

    $folder_container = "assets/images/artwork/";


    foreach ($_FILES as $file) {

        if ($tag == 'music') {
            $folder_container = "assets/images/artwork/";
            $target_file = $folder_container . $file['name'];
            $dbtarget_file = "https://artist.mwonyaa.com/assets/images/artwork/" . $file['name'];
        } elseif ($tag == 'podcast') {
            $folder_container = "assets/images/podcastalbumartwork/";
            $target_file = $folder_container . $file['name'];
            $dbtarget_file = "https://artist.mwonyaa.com/assets/images/podcastalbumartwork/" . $file['name'];
        } elseif ($tag == 'dj') {
            $folder_container = "assets/images/podcastalbumartwork/";
            $target_file = $folder_container . $file['name'];
            $dbtarget_file = "https://artist.mwonyaa.com/assets/images/podcastalbumartwork/" . $file['name'];
        } elseif ($tag == 'poem') {
            $folder_container = "assets/images/poemsartwork/";
            $target_file = $folder_container . $file['name'];
            $dbtarget_file = "https://artist.mwonyaa.com/assets/images/poemsartwork/" . $file['name'];
        } else {
            echo "Media Tag is Not Provided";
            return;
        }

        if (!file_exists($folder_container)) {
            mkdir($folder_container, 0777, true);
        }


        // Get file extension
        $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("png", "jpg", "JPEG", "jpeg");

        if ($AlbumTitle == "" && $mediaArtist == "" && $mediaDescription == "" && $mediaGenre == "Choose Genre" && $tag = "") {
            echo "Error Saving Info due to missing parts";
        } else if (!file_exists($file['tmp_name'])) {

            echo "select Media to upload";
        }
        //  else if (!in_array($imageExt, $allowd_file_ext)) {
        //     echo "wrong file format. only mp3 files allowed";
        // } 

        else {


            $checkduplicate = mysqli_query($con, "SELECT * FROM albums WHERE title='$AlbumTitle' AND path ='$dbtarget_file'");

            if ($checkduplicate) {

                if (mysqli_num_rows($checkduplicate) >= 1) {
                    echo $AlbumTitle . "<span class='fileexistdanger' style='color: red;'>file already Exists</span>" . "\n";
                    continue;
                } else {

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {

                        $sql = "INSERT INTO albums (id,title,artist,genre,artworkPath,tag,description) VALUES ('$id','$AlbumTitle','$mediaArtist','$mediaGenre','$dbtarget_file','$tag','$mediaDescription')";
    
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute()) {
                        
                            echo $AlbumTitle . "<span class='checkeddone' style='color: green; font-weight:bold;'> Done</span>" . "\n";
                        } else {
                            echo "Media upload to Database Failed" . "\n";
                            continue;
                        }
                    } else {
                        echo "Media Upload Failed. Try again" . "\n";
                        continue;
                    }
                }
            } else {
                if (move_uploaded_file($file['tmp_name'], $target_file)) {

                    $sql = "INSERT INTO albums (id,title,artist,genre,artworkPath,tag,description) VALUES ('$id','$AlbumTitle','$mediaArtist','$mediaGenre','$dbtarget_file','$tag','$mediaDescription')";

                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        echo $AlbumTitle . "<span class='checkeddone' style='color: green; font-weight:bold;'> Done</span>" . "\n";
                    } else {
                        echo "Media upload to Database Failed" . "\n";
                        continue;
                    }
                } else {
                    echo "Media Upload Failed. Try again" . "\n";
                    continue;
                }
            }
        }
    }
}
