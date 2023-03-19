<?php

include("config/database.php");
include("config/MP3File.php");

function sanitizeFormInput($inputText): string
{
    return strip_tags($inputText);
}


// Get input data
$albumTitle = sanitizeFormInput($_POST['albumTitle']);
$id = sanitizeFormInput($_POST['album_id']);
$genreId = sanitizeFormInput($_POST['mediaGenre']);
$releaseDate = sanitizeFormInput($_POST['releaseDate']);
$description = sanitizeFormInput($_POST['mediaDescription']);
$artistId = sanitizeFormInput($_POST['artistselect']);
$artWorkFile = $_FILES['artWorkPath'];
$trackFile = $_FILES['trackPath'];
$trackTitle = sanitizeFormInput($_POST['trackTitle']);
$tag = sanitizeFormInput($_POST["contenttype"]);
$plays = 0;

$i = 1;

$folder_container = "assets/music/";

addTrackContainer($artWorkFile, $tag, $conn,$id, $albumTitle, $artistId, $genreId, $releaseDate,$description);


//// set folders for upload
//if ($tag == 'music') {
//    $folder_container = "assets/music/";
//    $target_file = $folder_container . $trackFile['name'];
//    $dbtarget_file = "https://artist.mwonya.com/assets/music/" . $trackFile['name'];
//} elseif ($tag == 'podcast') {
//    $folder_container = "assets/podcasts/";
//    $target_file = $folder_container . $trackFile['name'];
//    $dbtarget_file = "https://artist.mwonya.com/assets/podcasts/" . $trackFile['name'];
//} elseif ($tag == 'dj') {
//    $folder_container = "assets/djmixes/";
//    $target_file = $folder_container . $trackFile['name'];
//    $dbtarget_file = "https://artist.mwonya.com/assets/djmixes/" . $trackFile['name'];
//} elseif ($tag == 'poem') {
//    $folder_container = "assets/poems/";
//    $target_file = $folder_container . $trackFile['name'];
//    $dbtarget_file = "https://artist.mwonya.com/assets/poems/" . $trackFile['name'];
//} else {
//    echo "Media Tag is Not Provided";
//    return;
//}
//
//if (!file_exists($folder_container)) {
//    mkdir($folder_container, 0777, true);
//}


function addTrackContainer($album_artWorkFile, $albumtage, $conn, $id, $albumTitle, $albumArtist, $albumGenre,$release, $albumDescription)
{


    if ($albumtage == 'music') {
        $folder_container = "assets/images/artwork/";
        $target_file = $folder_container . $album_artWorkFile['name'];
        $dbtarget_file = "https://artist.mwonya.com/assets/images/artwork/" . $album_artWorkFile['name'];
    } elseif ($albumtage == 'podcast') {
        $folder_container = "assets/images/podcastalbumartwork/";
        $target_file = $folder_container . $album_artWorkFile['name'];
        $dbtarget_file = "https://artist.mwonya.com/assets/images/podcastalbumartwork/" . $album_artWorkFile['name'];
    } elseif ($albumtage == 'dj') {
        $folder_container = "assets/images/podcastalbumartwork/";
        $target_file = $folder_container . $album_artWorkFile['name'];
        $dbtarget_file = "https://artist.mwonya.com/assets/images/podcastalbumartwork/" . $album_artWorkFile['name'];
    } elseif ($albumtage == 'poem') {
        $folder_container = "assets/images/poemsartwork/";
        $target_file = $folder_container . $album_artWorkFile['name'];
        $dbtarget_file = "https://artist.mwonya.com/assets/images/poemsartwork/" . $album_artWorkFile['name'];
    } else {
        echo "Media Tag is Not Provided";
        return;
    }

    if (!file_exists($folder_container)) {
        mkdir($folder_container, 0777, true);
    } else {

        $checkduplicate = $conn->prepare("SELECT * FROM albums WHERE id=:id");
        $checkduplicate->execute(array(':id' => $id));

        if ($checkduplicate->rowCount() >= 1) {
            echo $albumTitle . "<span class='fileexistdanger' style='color: red;'>file already Exists in Database</span>" . "\n";
        } else {
            if (move_uploaded_file($album_artWorkFile['tmp_name'], $target_file)) {

                $sql = "INSERT INTO albums (id, title, artist, genre, artworkPath, tag, releaseDate, description, AES_code) VALUES (:id, :title, :artist, :genre, :artworkPath, :tag, :releaseDate, :description, 'single')";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':title', $albumTitle);
                $stmt->bindParam(':artist', $albumArtist);
                $stmt->bindParam(':genre', $albumGenre);
                $stmt->bindParam(':artworkPath', $dbtarget_file);
                $stmt->bindParam(':tag', $albumtage);
                $stmt->bindParam(':releaseDate', $release);
                $stmt->bindParam(':description', $albumDescription);

                if ($stmt->execute()) {
                    echo $albumTitle . "<span class='checkeddone' style='color: green; font-weight:bold;'> Done</span>" . "\n";
                } else {
                    echo "Media upload to Database Failed" . "\n";
                }
            } else {
                echo "Media Upload Failed. Try again" . "\n";
            }
        }

    }
}


?>
