<?php

include("config/database.php");
include("config/MP3File.php");


if (isset($_POST["username"])) {

    // $albumtitle = $_POST["songtile"];
    $selectArtist = $_POST["songartist"];
    $selectAlbum = $_POST["songAlbum"];
    $selectGenre = $_POST["songGenre"];
    $tag = $_POST["songtag"];
    $plays = 0;


    $i = 1;


    foreach ($_FILES as $file) {

        if ($tag == 'music') {
            $target_file = "../assets/music/" . $file['name'];
            $dbtarget_file = "assets/music/" . $file['name'];
        } elseif ($tag == 'podcast') {
            $target_file = "../assets/podcasts/" . $file['name'];
            $dbtarget_file = "assets/podcasts/" . $file['name'];
        } elseif ($tag == 'dj') {
            $target_file = "../assets/djmixes/" . $file['name'];
            $dbtarget_file = "assets/djmixes/" . $file['name'];
        } elseif ($tag == 'poem') {
            $target_file = "../assets/poems/" . $file['name'];
            $dbtarget_file = "assets/poems/" . $file['name'];
        } else {
            echo "Media Tag is Not Provided";
            return;
        }



        $path_parts = pathinfo($dbtarget_file);

        // echo $path_parts['dirname'], "\n";
        // echo $path_parts['basename'], "\n";
        // echo $path_parts['extension'], "\n";
        // echo $path_parts['filename'], "\n";

        //get albumsongorder
        $orderIdQuery = "SELECT IFNULL(max(albumOrder)+1, 1) AS albumOrder FROM songs WHERE album ='$selectAlbum'";
        //prepareorder
        $stmtorder = $conn->prepare($orderIdQuery);
        $stmtorder->execute();
        $albumOrder = $stmtorder->fetchAll();

        //album order
        $albumOrder = $albumOrder[0]['albumOrder'];

        $albumtitle = $path_parts['filename'];



        // Get file extension
        $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("mp3", "m4a", "MP3", "M4A");

        if ($albumtitle == "" && $selectArtist == "Choose Creator" && $selectAlbum == "Choose Album" && $selectGenre == "Choose Genre" && $duration = "" && $tag = "") {
            echo "input files cannot be empty";
        } else if (!file_exists($file['tmp_name'])) {

            echo "select song to upload";
        }
        //  else if (!in_array($imageExt, $allowd_file_ext)) {
        //     echo "wrong file format. only mp3 files allowed";
        // } 

        else {


            $checkduplicate = mysqli_query($con, "SELECT * FROM songs WHERE title='$albumtitle' AND path ='$dbtarget_file'");

            if ($checkduplicate) {

                if (mysqli_num_rows($checkduplicate) >= 1) {
                    echo $albumtitle . "<span class='fileexistdanger' style='color: red;'>file already Exists</span>" . "\n";
                    continue;
                } else {

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {

                        $mp3file = new MP3File($target_file); //http://www.npr.org/rss/podcast.php?id=510282
                        $duration1 = $mp3file->getDurationEstimate(); //(faster) for CBR only
                        $duration2 = $mp3file->getDuration(); //(slower) for VBR (or CBR)
                        // echo "duration: $duration1 seconds" . "\n";
                        // echo "estimate: $duration2 seconds" . "\n";
                        $duration =  MP3File::formatMusicTime($duration2);

                        $sql = "INSERT INTO songs (title,artist,album,genre,duration,path,albumOrder,plays,tag) VALUES ('$albumtitle','$selectArtist','$selectAlbum','$selectGenre','$duration','$dbtarget_file','$albumOrder','$plays','$tag')";
                        $query = mysqli_query($con, $sql);

                        if ($query) {


                            echo
                            $albumtitle . "<span class='checkeddone'>Done</span>" . "\n";
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

                    $mp3file = new MP3File($target_file); //http://www.npr.org/rss/podcast.php?id=510282
                    $duration1 = $mp3file->getDurationEstimate(); //(faster) for CBR only
                    $duration2 = $mp3file->getDuration(); //(slower) for VBR (or CBR)
                    // echo "duration: $duration1 seconds" . "\n";
                    // echo "estimate: $duration2 seconds" . "\n";
                    $duration =  MP3File::formatMusicTime($duration2);

                    $sql = "INSERT INTO songs (title,artist,album,genre,duration,path,albumOrder,plays,tag) VALUES ('$albumtitle','$selectArtist','$selectAlbum','$selectGenre','$duration','$dbtarget_file','$albumOrder','$plays','$tag')";
                    $query = mysqli_query($con, $sql);

                    if ($query) {
                        echo "Done";

                        echo
                        $albumtitle . "<span class='checkeddone' style='color: green; font-weight:bold;'> Done</span>" . "\n";
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