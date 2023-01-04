<?php
include("../config/database.php");
include("../config/MP3File.php");

// check if post values exist
if (isset($_POST["username"]) && isset($_POST["artistidgot"]) && isset($_FILES["file"])) {
    // connect to database
    if (mysqli_connect_errno()) {
        // there was an error connecting to the database
        echo "Error connecting to database: " . mysqli_connect_error();
        exit();
    }

    $selectartist = $_POST["artistidgot"];
    $username = $_POST["username"];
    // process uploaded file
    $target_dir = "../assets/images/artistprofiles/";
    $dbtarget_dir = "https://artist.mwonyaa.com/assets/images/artistprofiles/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }


    $temp = explode(".", $_FILES["file"]["name"]);
    // $newfilename = round(microtime(true)) . '.ll' . end($temp);

    $postfix = '_' . date('YmdH') . '_' . $username. '_' . $selectartist;
    $newfilename = stripslashes("artist_cover") . $postfix . '.' . end($temp);


    // $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    // $dbtarget_file = $dbtarget_dir . basename($_FILES["fileUpload"]["name"]);

    $target_file = $target_dir . basename($newfilename);
    $dbtarget_file = $dbtarget_dir . basename($newfilename);

    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // file was successfully uploaded
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // file was successfully moved to target folder
            // update database record
            $stmt = mysqli_prepare($con, "UPDATE artists SET coverimage=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "si", $dbtarget_file, $selectartist);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // database query was successful
                echo "Media uploaded successfully.";
            } else {
                // database query failed
                echo "Error updating database record. Try again.";
            }
            mysqli_stmt_close($stmt);
        } else {
            // file upload failed
            echo "Artwork Failed. Try again";
        }
    } else {
        // there was an error uploading the file
        switch ($_FILES["file"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
                // file is larger than the maximum allowed size
                echo "The uploaded file exceeds the maximum file size.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                // file is larger than the maximum allowed size in the HTML form
                echo "The uploaded file exceeds the maximum file size specified in the HTML form.";
                break;
            case UPLOAD_ERR_PARTIAL:
                // file was only partially uploaded
                echo "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                // no file was uploaded
                echo "No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                // missing a temporary folder
                echo "Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                // failed to write file to disk
                echo "Failed to write file to disk.";
                break;
            default:
                // unknown error
                echo "An unknown error occurred while uploading the file.";
                break;
        }
    }

    // close database connection
    mysqli_close($con);
} else {
    // one or more post values do not exist
    echo "Missing required information. Try again.";
}

