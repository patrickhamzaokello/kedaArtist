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


addTrackContainer($artWorkFile, $tag, $conn, $id, $albumTitle, $artistId, $genreId, $releaseDate, $description);
addTrack($conn, $trackFile,$trackTitle, $tag,$id,$artistId,$genreId,$releaseDate);


function addTrackContainer($album_artWorkFile, $albumtage, $conn, $id, $albumTitle, $albumArtist, $albumGenre, $release, $albumDescription)
{

    // Check if album tag is provided
    if (empty($albumtage)) {
        echo "<span class='fileexistdanger' style='color: red;'>Media Tag is Not Provided</span>" . "\n";
        return;
    }

    // Define folder container and target file path based on album tag
    switch ($albumtage) {
        case 'music':
            $folder_container = "assets/images/artwork/";
            break;
        case 'podcast':
        case 'dj':
            $folder_container = "assets/images/podcastalbumartwork/";
            break;
        case 'poem':
            $folder_container = "assets/images/poemsartwork/";
            break;
        default:
            echo "<span class='fileexistdanger' style='color: red;'>Invalid Media Tag</span>" . "\n";
            return;
    }
    $target_file = $folder_container . $album_artWorkFile['name'];
    $dbtarget_file = "https://artist.mwonya.com/" . $target_file;

    // Check if folder container exists, if not, create it
    if (!file_exists($folder_container)) {
        mkdir($folder_container, 0777, true);
    }


    // Check if album title, artist, genre, release date, and description are provided
    if (empty($albumTitle) || empty($albumArtist) || empty($albumGenre) || empty($release) || empty($albumDescription)) {
        echo "<span class='fileexistdanger' style='color: red;'>Please fill in all required fields</span>" . "\n";
        return;
    }

    // Check if album artwork file is provided and is a valid image file
    if (empty($album_artWorkFile) || !in_array(strtolower(pathinfo($album_artWorkFile['name'], PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'png'))) {
        echo "<span class='fileexistdanger' style='color: red;'>Invalid Album Artwork File. Please upload a valid image file (JPG, JPEG, PNG)</span>" . "\n";
        return;
    }

    // Check if album with provided id already exists
    $checkduplicate = $conn->prepare("SELECT * FROM albums WHERE id=:id");
    $checkduplicate->execute(array(':id' => $id));
    if ($checkduplicate->rowCount() >= 1) {
        echo "<span class='fileexistdanger' style='color: red;'>".$albumTitle . "Media file already Exists in Database</span>" . "\n";
        return;
    }


// Move album artwork file to target folder
    if (move_uploaded_file($album_artWorkFile['tmp_name'], $target_file)) {

        // Insert album information into database
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
            echo"<span class='checkeddone' style='color: green; font-weight:bold;'>". $albumTitle ."  Uploaded</span>" . "\n";
        } else {
            echo "<span class='checkeddone' style='color: green; font-weight:bold;'>Media upload to Database Failed</span>" . "\n";
        }
    } else {
        echo "<span class='checkeddone' style='color: green; font-weight:bold;'>Media Upload Failed. Try again</span>" . "\n";
    }


}


function addTrack($conn, $trackFile, $track_title, $track_tag, $album_id, $track_Artist, $track_genre, $release_date)
{

    // Check if album tag is provided
    if (empty($track_tag)) {
        echo "<span class='fileexistdanger' style='color: red;'>Track Tag is Not Provided</span>" . "\n";
        return;
    }

    // Define folder container and target file path based on album tag
    switch ($track_tag) {
        case 'music':
            $folder_container = "assets/music/";
            break;
        case 'podcast':
            $folder_container = "assets/podcasts/";
            break;
        case 'dj':
            $folder_container = "assets/djmixes/";
            break;
        case 'poem':
            $folder_container = "assets/poems/";
            break;
        default:
            echo "<span class='fileexistdanger' style='color: red;'>Invalid Media Tag</span>" . "\n";
            return;
    }
    $target_file = $folder_container . $trackFile['name'];
    $dbtarget_file = "https://artist.mwonya.com/" . $target_file;

    // Check if folder container exists, if not, create it
    if (!file_exists($folder_container)) {
        mkdir($folder_container, 0777, true);
    }


    // Check if track title, artist, genre, release date, and description are provided
    if (empty($track_title) || empty($album_id) || empty($track_Artist) || empty($track_genre) || empty($release_date)) {
        echo "<span class='fileexistdanger' style='color: red;'>Please fill in all required fields</span>" . "\n";
        return;
    }

    // Check if track artwork file is provided and is a valid image file
    if (empty($trackFile) || !in_array(strtolower(pathinfo($trackFile['name'], PATHINFO_EXTENSION)), array('mp3', 'wav', 'aac', 'ogg', 'm4a'))) {
        echo "<span class='fileexistdanger' style='color: red;'>Invalid Audio File. Please upload a valid image file (MP3, WAV, AAC, OGG, M4a)</span>" . "\n";
        return;
    }

    // Check if track with provided title, artist and album already exists
    $checkduplicate = $conn->prepare("SELECT * FROM songs WHERE title=:title AND artist=:artist AND album=:album");
    $checkduplicate->execute(array(':title' => $track_title,':artist'=> $track_Artist,':album'=> $album_id));
    if ($checkduplicate->rowCount() >= 1) {
        echo  "<span class='fileexistdanger' style='color: red;'>".$track_title ." track already Exists in Database</span>" . "\n";
        return;
    }


// Move track audio file to target folder
    if (move_uploaded_file($trackFile['tmp_name'], $target_file)) {

        $sql = "SELECT COALESCE(MAX(albumOrder) + 1, 1) AS albumOrder FROM songs WHERE album = :album";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':album' => $album_id));
        $albumOrder = $stmt->fetch(PDO::FETCH_ASSOC)['albumOrder'];

        // Insert track information into database
        $sql = "INSERT INTO songs (title,artist,album,genre,path,albumOrder,releaseDate,tag) VALUES (:title, :artist, :album, :genre, :trackFilePath, :albumOrder, :releaseDate, :tag)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $track_title);
        $stmt->bindParam(':artist', $track_Artist);
        $stmt->bindParam(':album', $album_id);
        $stmt->bindParam(':genre', $track_genre);
        $stmt->bindParam(':trackFilePath', $dbtarget_file);
        $stmt->bindParam(':albumOrder', $albumOrder);
        $stmt->bindParam(':releaseDate', $release_date);
        $stmt->bindParam(':tag', $track_tag);

        if ($stmt->execute()) {
            echo "<span class='checkeddone' style='color: green; font-weight:bold;'>".$track_title ."   Uploaded Successfully</span>" . "\n";
        } else {
            echo "<span class='checkeddone' style='color: green; font-weight:bold;'> Audio upload to Database Failed</span>" . "\n";
        }
    } else {
        echo "<span class='checkeddone' style='color: green; font-weight:bold;'> Audio Upload Failed. Try again</span>" . "\n";
    }


}


?>
