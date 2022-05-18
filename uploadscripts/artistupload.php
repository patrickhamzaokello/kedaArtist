<?php

// Database connection
include("config/database.php");




if (isset($_POST["submit"])) {
    $target_dir = "assets/images/artistprofiles/";
    $dbtarget_dir = "https://artist.mwonyaa.com/assets/images/artistprofiles/";


    //Get Artist
    $artistnam = $_POST['Artistname'];
    $artistname = addslashes($artistnam);
    $recordLabel = $_POST['artistLabel'];
    $phoneNO = $_POST['artistphone'];
    $email = $_POST['Artistemail'];
    $password = $_POST['Artistpassword'];
    $confirmPassword = $_POST['Artistconfirmpassword'];



    //social details
    $artistFacebookurl = $_POST['artistFacebookurl'];
    $artistInstagramurl = $_POST['artistInstagramurl'];
    $artistTwitterurl = $_POST['artistTwitterurl'];

    $firstthreeletters = substr($email, 0, 3);
    $id = "martist" . uniqid() . $firstthreeletters;

    //change image names
    $temp = explode(".", $_FILES["fileUpload"]["name"]);
    $tempCover = explode(".", $_FILES["coverUpload"]["name"]);

    $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
    $newfilename = stripslashes($artistname . '_profile') . $postfix . '.' . end($temp);
    $newfilecovername = stripslashes($artistname . '_cover') . $postfix . '.' . end($tempCover);

    $target_file = $target_dir . basename($newfilename);
    $covertarget_file = $target_dir . basename($newfilecovername);

    $dbtarget_file = $dbtarget_dir . basename($newfilename);
    $dbcovertarget_file = $dbtarget_dir . basename($newfilecovername);

    if (strcasecmp($confirmPassword, $password) != 0) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "- Passwords Don't Match, Try again"
        );
    } else {
        $result = mysqli_query($con, "SELECT * FROM artists WHERE email='$email' or name='$artistname'");
        $row  = mysqli_fetch_array($result);
        if (is_array($row)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "- The email or Artistname or Password is already taken, Try another one"
            );
        } else {
            // Get file extension
            $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Allowed file types
            $allowd_file_ext = array("jpg", "jpeg", "png", "mp3");

            if ($contentType == "Choose Content Type") {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => " please specify if you will be doing music, podcast or others."
                );
            }

            if ($selectOption == "Choose Genre") {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Select the Genre you Belong to."
                );
            }


            if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Select image to upload."
                );
            } else if (!file_exists($_FILES["coverUpload"]["tmp_name"])) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Select image to upload."
                );
            } else if (!in_array($imageExt, $allowd_file_ext)) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Allowed file formats .jpg, .jpeg and .png."
                );
            } else if ($_FILES["fileUpload"]["size"] > 80097152 || $_FILES["coverUpload"]["size"] > 80097152) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "File is too large. File size should be less than 2 megabytes."
                );
            } else if (file_exists($target_file) || file_exists($covertarget_file)) {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "File already exists."
                );
            } else {
                if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $covertarget_file)) {
                    $sql = "INSERT INTO artists (id,name,email,phone, facebookurl, twitterurl, instagramurl,RecordLable,password,profilephoto,coverimage) VALUES ('$id','$artistname','$email','$phoneNO','$artistFacebookurl', '$artistTwitterurl', '$artistInstagramurl', '$recordLabel','$password','$dbtarget_file','$dbcovertarget_file')";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        $resMessage = array(
                            "status" => "alert-success",
                            "message" => "Image uploaded successfully."
                        );

                        header("Location:login");
                    }
                } else {
                    $resMessage = array(
                        "status" => "alert-danger",
                        "message" => "Image coudn't be uploaded."
                    );
                }
            }
        }
    }




    //check if user exist


}
