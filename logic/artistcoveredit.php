<?php

include("../config/database.php");
include("../config/MP3File.php");


if (isset($_POST["username"])) {



    $selectartist = $_POST["artistidgot"];

    foreach ($_FILES as $file) {


        $target_file = "../../assets/images/artistprofiles/" . $file['name'];
        $dbtarget_file = "assets/images/artistprofiles/" . $file['name'];


        $path_parts = pathinfo($dbtarget_file);

        $albumtitle = $path_parts['filename'];


        if (move_uploaded_file($file['tmp_name'], $target_file)) {

            $query = mysqli_query($con, "UPDATE  artists SET coverimage='$dbtarget_file' WHERE id='$selectartist'");

            if ($query) {
                // echo "Song uploaded successfully.";

                echo $albumtitle, ",\n";
            }
        } else {
            echo "Artwork Failed. Try again";
        }
    }

    echo "Media uploaded successfully.";
}