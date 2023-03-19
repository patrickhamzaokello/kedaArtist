<?php

if (isset($_GET['tag'])) {
    $mediaTag =  $_GET['tag'];
    $mediaTag = clean($mediaTag);

    $tag_array = ["music", "dj", "podcast", "poem"];
    if (stripos(json_encode($tag_array), $mediaTag) !== false) {
        // echo "found mystring";
        $mediaTag =  $mediaTag;
    } else {
        $mediaTag =  "notfound";
        header("Location:home");
    }
} else {
    $mediaTag =  "music";
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    include("config/global.php");
    include("config/database.php");
    include("config/errorhandler.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");
    include("includes/classes/LikedSong.php");

    if (isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    } else {
        echo "username variable was not passed into the page check the openPage js function";
        exit();
    }
} else {
    include("managecontent.php");


    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}


function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

?>


<script>
    function _(id) {
        return document.getElementById(id);
    }



    function saveSinglesToDB() {
        // Get the input field values
        var contentType = _("contenttype").value;
        var artistSelect = _("mediaArtist").value;
        var trackTitle = _("trackTitle").value;
        var albumTitle = _("AlbumTitle").value;
        var mediaGenre = _("mediaGenre").value;
        var releaseDate = _("releaseDate").value;
        var artWorkPath = _("artWorkPath").files[0];
        var trackPath = _("trackPath").files[0];
        var mediaDescription = _("mediaDescription").value;

        const firstThreeLetters = Math.floor(Math.random() * 1000).toString().substr(0, 3);
        const mediaAlbumID = "m_al" + Date.now().toString(36) + firstThreeLetters;


        console.log(contentType + "- "+mediaAlbumID + "- "+ artistSelect + "- "+ trackTitle + "- "+ albumTitle + "- "+ mediaGenre + "- "+ releaseDate + "- "+ artWorkPath + "- "+ trackPath + "- "+ mediaDescription)

        // Create a FormData object and append the input field values
        var formData = new FormData();
        formData.append("contenttype", contentType);
        formData.append("artistselect", artistSelect);
        formData.append("trackTitle", trackTitle);
        formData.append("albumTitle", albumTitle);
        formData.append("mediaGenre", mediaGenre);
        formData.append("album_id", mediaAlbumID);
        formData.append("releaseDate", releaseDate);
        formData.append("artWorkPath", artWorkPath);
        formData.append("trackPath", trackPath);
        formData.append("mediaDescription", mediaDescription);

        // Create an XMLHttpRequest object and send a POST request to a PHP script
        $('.uploadoverview').css('display', 'grid');
        $('#progressBar').css('display', 'block');

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.open("POST", "singleupload");
        ajax.send(formData);
    }


    function progressHandler(event) {
        _("loaded_n_total").innerHTML = "(UpLoaded " + Math.round(event.loaded * 0.000001) + " / " + Math.round(event
            .total * 0.000001) + " Mbs)";
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent) + " % Uploading... please wait";
    }

    function completeHandler(event) {
        _("status").innerHTML = event.target.responseText;
        _("progressBar").value = 0;
        _("upload_form").reset();
        $('#progressBar').css('display', 'none');

    }
</script>


<?php

//Our select statement. This will retrieve the data that we want.
$sqlgenre = "SELECT id, name FROM genres  ORDER BY `genres`.`name` ASC";

$sqlalbum = "SELECT id, title From albums WHERE artist='$artistid' AND tag='$mediaTag'";
//ordeer


//Prepare the select statement.
$stmtgrenre = $conn->prepare($sqlgenre);
$stmtalbum = $conn->prepare($sqlalbum);




//Execute the statement.
$stmtgrenre->execute();
$stmtalbum->execute();


//Retrieve the rows using fetchAll.
$genres = $stmtgrenre->fetchAll();
$albums = $stmtalbum->fetchAll();

?>





<div class="create_media_container">

    <div class="mediaCreationheading" style="text-align: center;">
        <h5>Media Container Creation Form</h5>
        <p style="font-size: 0.7em;color: #8b7097;">Create Container for a single, EP, Album, Mixtape or Podcast </p>
        <!-- <h5>EP (Extended Play) Creation Form</h5> -->

    </div>
    <div class="loginforminner  slide-in-right">

        <!-- Display response messages -->
        <?php if (!empty($resMessage)) { ?>
            <div class=" alert <?php echo $resMessage['status'] ?>">
                <?php echo $resMessage['message'] ?>
            </div>
        <?php } ?>


        <form enctype="multipart/form-data" method="post" id="upload_form">

            <div class="inputformelement" style="display: none;">
                <input type="text" name="contenttype" class="inputarea disabledinput" readonly="" id="contenttype" aria-describedby="nameHelp" value="<?= $mediaTag ?>">
            </div>

            <div class="inputformelement" style="display: none;">
                <label class="submitedlable" for="mediaArtist">Creator</label>
                <select name="artistselect" id="mediaArtist" class="mediauploadInput">
                    <option selected value="<?= $artistid; ?>"><?= $artistname ?></option>
                </select>
            </div>

            <div class="inputformelement">
                <label class="submitedlable" for="trackTitle">Track Title <span class="required">*</span></label>
                <input type="text" name="trackTitle" required class="mediauploadInput" id="trackTitle" aria-describedby="nameHelp" placeholder="Enter Track Title">
            </div>

            <div class="inputformelement">
                <label class="submitedlable" for="AlbumTitle">Album / Ep Name <span class="required">*</span></label>
                <input type="text" name="AlbumTitle" required class="mediauploadInput" id="AlbumTitle" aria-describedby="nameHelp" placeholder="Enter Album / EP Name">
            </div>


            <div class="inputformelement">
                <label class="submitedlable" for="mediaGenre">Genre <span class="required">*</span></label>
                <select id="mediaGenre" required class="mediauploadInput">
                    <option value="">Choose Genre</option>
                    <?php foreach ($genres as $genre) : ?>
                        <option value="<?= $genre['id']; ?>"><?= $genre['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="inputformelement">

                <div class="custom-file">
                    <label class="submitedlable" for="releaseDate">Release Date & Time <span class="required">*</span></label>

                    <input type="datetime-local" name="releaseDate" id="releaseDate" class="mediaFileinput" >

                </div>
            </div>


            <div class="inputformelement">

                <div class="custom-file">
                    <label class="submitedlable" for="artWorkPath">Track Artwork <span class="required">*</span></label>

                    <input type="file" id="artWorkPath" name="artWorkPath" class="mediaFileinput" accept=".jpg, .png, .jpeg" type="file">

                </div>
            </div>



            <div class="inputformelement">

                <div class="custom-file">
                    <label class="submitedlable" for="trackPath">Track Path <span class="required">*</span></label>

                    <input type="file" id="trackPath" name="trackPath" class="mediaFileinput" accept=".mp3"  type="file">

                </div>
            </div>


            <div class="inputformelement">
                <label for="mediaDescription" class="submitedlable">Description <span class="required">*</span></label>
                <textarea type="textarea" rows="5" required name="mediaDescription" class="mediauploadInput" id="mediaDescription" aria-describedby="descriptionHelp" placeholder="Album Description"></textarea>
            </div>

            <input class="uploadtracksbtn" type="button" value="Create Container" onclick="saveSinglesToDB()">


            <p class="helptext" style="margin-top: 1em;">+ This form Creates an empty Media container. Remember to Add tracks to this Container later</p>
        </form>
    </div>
</div>

<div class="uploadoverview">
    <div class="progressview">
        <progress id="progressBar" value="0" max="100"></progress>

        <h6 class="progressLoadingtext" id="status" wrap="hard"></h6>
        <p id="loaded_n_total" class="progressupdateSize"></p>
        <input class="uploadtracksbtn" type="button" value="Done" onclick="openPage('home')">
    </div>

</div>