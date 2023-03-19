<?php

include("config/database.php");
include("config/MP3File.php");

function sanitizeFormInput($inputText): string
{
    return strip_tags($inputText);
}


// Get input data
$albumTitle = sanitizeFormInput($_POST['albumTitle']);
$album_id = sanitizeFormInput($_POST['album_id']);
$genreId = sanitizeFormInput($_POST['mediaGenre']);
$releaseDate = sanitizeFormInput($_POST['releaseDate']);
$description = sanitizeFormInput($_POST['mediaDescription']);
$artistId = sanitizeFormInput($_POST['artistselect']);
$artWorkFile = $_FILES['artWorkPath'];
$trackFile = $_FILES['trackPath'];
$trackTitle = sanitizeFormInput($_POST['trackTitle']);
$tag = sanitizeFormInput($_POST["contenttype"]);


addTrackContainer($conn, $artWorkFile, $tag, $album_id, $albumTitle, $artistId, $genreId, $releaseDate, $description, $trackFile,$trackTitle);



function addTrackContainer($conn, $album_artWorkFile, $tag, $album_id, $albumTitle, $albumArtist, $albumGenre, $release, $albumDescription, $trackFile, $track_title)
{

// Check if album tag is provided
    if (empty($tag)) {
        echo "<span class='fileexistdanger' style='color: red;'>Media Tag is Not Provided</span>" . "\n";
        return;
    }

// Define folder container and target file path based on album tag
    switch ($tag) {
        case 'music':
            $folder_container = "assets/images/artwork/";
            $folder_container_tracks = "assets/music/";
            break;
        case 'podcast':
        case 'dj':
            $folder_container = "assets/images/podcastalbumartwork/";
            $folder_container_tracks = "assets/podcasts/";
            break;
        case 'poem':
            $folder_container = "assets/images/poemsartwork/";
            $folder_container_tracks = "assets/poems/";
            break;
        default:
            echo "<span class='fileexistdanger' style='color: red;'>Invalid Media Tag</span>" . "\n";
            return;
    }

    // Define target file paths for album artwork and track files
    $target_file_artwork = $folder_container . $album_artWorkFile['name'];
    $target_file_track = $folder_container_tracks . $trackFile['name'];
    $dbtarget_file_artwork = "https://artist.mwonya.com/" . $target_file_artwork;
    $dbtarget_file_track = "https://artist.mwonya.com/" . $target_file_track;

    // Check if folder containers exist, if not, create them
    if (!file_exists($folder_container)) {
        mkdir($folder_container, 0777, true);
    }

    if (!file_exists($folder_container_tracks)) {
        mkdir($folder_container_tracks, 0777, true);
    }

// Check if album title, artist, genre, release date, and description are provided
    if (empty($albumTitle) || empty($albumArtist) || empty($albumGenre) || empty($release) || empty($albumDescription)) {
        echo "<span class='fileexistdanger' style='color: red;'>Please fill in all required fields for media</span>" . "\n";
        return;
    }

// Check if track title, artist, genre, release date, and album id are provided
    if (empty($track_title) || empty($albumArtist) || empty($albumGenre) || empty($release) || empty($album_id)) {
        echo "<span class='fileexistdanger' style='color: red;'>Please fill in all required fields for track</span>" . "\n";
        return;
    }

// Check if album artwork file is provided and is a valid image file
    if (empty($album_artWorkFile) || !in_array(strtolower(pathinfo($album_artWorkFile['name'], PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'png'))) {
        echo "<span class='fileexistdanger' style='color: red;'>Invalid Album Artwork File. Please upload a valid image file (JPG, JPEG, PNG)</span>" . "\n";
        return;
    }

    // Check if track file is provided and is a valid audio file
    if (empty($trackFile) || !in_array(strtolower(pathinfo($trackFile['name'], PATHINFO_EXTENSION)), array('mp3', 'wav', 'aac', 'ogg', 'm4a'))) {
        echo "<span class='fileexistdanger' style='color: red;'>Invalid Audio File. Please upload a valid image file (MP3, WAV, AAC, OGG, M4a)</span>" . "\n";
        return;
    }

    // Check if album with provided id already exists
    $checkduplicate = $conn->prepare("SELECT * FROM albums WHERE id=:id");
    $checkduplicate->execute(array(':id' => $album_id));
    if ($checkduplicate->rowCount() >= 1) {
        echo "<span class='fileexistdanger' style='color: red;'>".$albumTitle . " Media file already Exists in Database</span>" . "\n";
        return;
    }

    // Check if track with provided title, artist and album already exists
    $checkduplicate = $conn->prepare("SELECT * FROM songs WHERE title=:title AND artist=:artist AND album=:album");
    $checkduplicate->execute(array(':title' => $track_title,':artist'=> $albumArtist,':album'=> $album_id));
    if ($checkduplicate->rowCount() >= 1) {
        echo  "<span class='fileexistdanger' style='color: red;'>".$track_title ." track already Exists in Database</span>" . "\n";
        return;
    }

    // Move album artwork file to target folder
    if (move_uploaded_file($album_artWorkFile['tmp_name'], $target_file_artwork)) {

        // Insert album information into database
        $sql = "INSERT INTO albums (id, title, artist, genre, artworkPath, tag, releaseDate, description, AES_code) VALUES (:id, :title, :artist, :genre, :artworkPath, :tag, :releaseDate, :description, 'single')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $album_id);
        $stmt->bindParam(':title', $albumTitle);
        $stmt->bindParam(':artist', $albumArtist);
        $stmt->bindParam(':genre', $albumGenre);
        $stmt->bindParam(':artworkPath', $dbtarget_file_artwork);
        $stmt->bindParam(':tag', $tag);
        $stmt->bindParam(':releaseDate', $release);
        $stmt->bindParam(':description', $albumDescription);

        if ($stmt->execute()) {

            // Move track audio file to target folder
            if (move_uploaded_file($trackFile['tmp_name'], $target_file_track)) {

                $sql = "SELECT COALESCE(MAX(albumOrder) + 1, 1) AS albumOrder FROM songs WHERE album = :album";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array(':album' => $album_id));
                $albumOrder = $stmt->fetch(PDO::FETCH_ASSOC)['albumOrder'];

                // Insert track information into database
                $sql = "INSERT INTO songs (title,artist,album,genre,path,albumOrder,releaseDate,tag) VALUES (:title, :artist, :album, :genre, :trackFilePath, :albumOrder, :releaseDate, :tag)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':title', $track_title);
                $stmt->bindParam(':artist', $albumArtist);
                $stmt->bindParam(':album', $album_id);
                $stmt->bindParam(':genre', $albumGenre);
                $stmt->bindParam(':trackFilePath', $dbtarget_file_track);
                $stmt->bindParam(':albumOrder', $albumOrder);
                $stmt->bindParam(':releaseDate', $release);
                $stmt->bindParam(':tag', $tag);

                if ($stmt->execute()) {
                    echo "<span class='checkeddone' style='color: green; font-weight:bold;'>".$track_title ."   Uploaded Successfully</span>" . "\n";
                    return;
                } else {
                    echo "<span class='checkeddone' style='color: green; font-weight:bold;'> Audio upload to Database Failed</span>" . "\n";
                    return;
                }
            } else {
                echo "<span class='checkeddone' style='color: green; font-weight:bold;'> Audio Upload Failed. Try again</span>" . "\n";
            }
            echo"<span class='checkeddone' style='color: green; font-weight:bold;'>". $albumTitle ."  Track Artwork Uploaded Successfully, </span>" . "\n";

        } else {
            echo "<span class='checkeddone' style='color: green; font-weight:bold;'>Media upload to Database Failed</span>" . "\n";
        }
    } else {
        echo "<span class='checkeddone' style='color: green; font-weight:bold;'>Media Upload Failed. Try again</span>" . "\n";
    }


}

?>
