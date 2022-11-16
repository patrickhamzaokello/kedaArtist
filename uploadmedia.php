<?php

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
    include("uploadscripts/collectionupload.php");

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




?>


<script>
    function _(id) {
        return document.getElementById(id);
    }

    function uploadFiles() {




        var allsafe = true;

        var formdata = new FormData();
        var ufiles = _("userfiles").files;

        if (ufiles.length == 0) {
            allsafe = false;

            _("userfiles").style.border = "1px solid red"
            setTimeout(function() {
                _("userfiles").style.border = "1px solid white";
            }, 2000)
        } else {

            for (var i = 0; i < ufiles.length; i++) {
                formdata.append("file_" + i, ufiles[i]);
                // ufiles.name (name /size / type)
            }

        }


        // var songtitle = _("songtitle").value;
        var songtag = _("contenttype").value;
        var songartist = _("songartist").value;
        var songAlbum = _("songAlbum").value;
        var songGenre = _("songGenre").value;



        if (songAlbum == "") {
            allsafe = false;
            _("songAlbum").style.border = "1px solid red";
            setTimeout(function() {
                _("songAlbum").style.border = "1px solid white";
            }, 2000)
        }
        if (songGenre == "") {
            allsafe = false;
            _("songGenre").style.border = "1px solid red";

            setTimeout(function() {
                _("songGenre").style.border = "1px solid white";
            }, 2000)

        } else {
            _("songAlbum").style.border = "1px solid white";
            _("songGenre").style.border = "1px solid white";

        }

        if (allsafe) {
            _("songAlbum").style.border = "1px solid white";
            _("songGenre").style.border = "1px solid white";
            _("userfiles").style.border = "1px solid white";


            formdata.append("username", "Patrick");

            // formdata.append("songtile", songtitle);
            formdata.append("songtag", songtag);
            formdata.append("songartist", songartist);
            formdata.append("songAlbum", songAlbum);
            formdata.append("songGenre", songGenre);

            $('#progressBar').css('display', 'block');


            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.open("POST", "parser");
            ajax.send(formdata);
        }



    }

    function progressHandler(event) {
        _("loaded_n_total").innerHTML = "Loaded " + Math.round(event.loaded * 0.000001) + " Mbs of " + Math.round(event
            .total * 0.000001);
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent) + "% Loading... please wait";
    }

    function completeHandler(event) {
        _("status").innerHTML = event.target.responseText;
        _("progressBar").value = 0;
        _("upload_form").reset();
        $('#progressBar').css('display', 'none');

    }
</script>


<?php
if ($contenttag == "music") {

    //Our select statement. This will retrieve the data that we want.
    $sqlgenre = "SELECT id, name FROM genres where tag='music' ORDER BY `genres`.`name` ASC";

    $sqlalbum = "SELECT id, title From albums WHERE tag='music' AND artist='$artistid'";
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
    echo " 
                        <li><a class='nav-link' href='createcollection'>New Media Collection</a></li> 
                        <li    class='active'><a class='nav-link' href='uploadmedia'>Add Songs</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                     
                        ";
} else if ($contenttag == "podcast") {

    //Our select statement. This will retrieve the data that we want.
    $sqlgenre = "SELECT id, name FROM genres where tag='other' ORDER BY `genres`.`name` ASC";

    $sqlalbum = "SELECT id, title From albums WHERE tag='podcast' AND artist='$artistid'";
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
    echo "
                       <li><a class='nav-link' href='createcollection'>Create Podcast Collection</a></li> 
                        <li  class='active'><a class='nav-link' href='uploadmedia'>Add Podcast</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
} else if ($contenttag == "dj") {

    //Our select statement. This will retrieve the data that we want.
    $sqlgenre = "SELECT id, name FROM genres where tag='other' ORDER BY `genres`.`name` ASC";

    $sqlalbum = "SELECT id, title From albums WHERE tag='dj' AND artist='$artistid'";
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
    echo "
                        <li><a class='nav-link' href='createcollection'>Create Mixtape Collection</a></li> 
                        <li class='active'><a class='nav-link' href='uploadmedia'>Add Mixtape</a></li>
                        <li ><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
} else if ($contenttag == "poem") {

    //Our select statement. This will retrieve the data that we want.
    $sqlgenre = "SELECT id, name FROM genres where tag='other' ORDER BY `genres`.`name` ASC";

    $sqlalbum = "SELECT id, title From albums WHERE tag='poem' AND artist='$artistid'";
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

    echo " 
                       <li><a class='nav-link' href='createcollection'>Create Poem Collection</a></li> 
                        <li   class='active'><a class='nav-link' href='uploadmedia'>Add Poem</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
} 
?>





    <div class="create_media_container">
        <div class="loginforminner  slide-in-right">

            <!-- Display response messages -->
            <?php if (!empty($resMessage)) { ?>
                <div class=" alert <?php echo $resMessage['status'] ?>">
                    <?php echo $resMessage['message'] ?>
                </div>
            <?php } ?>

            <div class="introtext">
                <h2>Media Upload</h2>
                <p>Upload Media to your account. songs uploaded will appear on the streaming site. Edits can be made
                    later</p>

            </div>
            <form enctype="multipart/form-data" method="post" id="upload_form">

                <div class="inputformelement">
                    <input type="text" name="contenttype" class="inputarea disabledinput" readonly id="contenttype" aria-describedby="nameHelp" value="<?= $contenttag ?>">
                </div>

                <div class="fileuploadform" style="display: none;">
                    <label for="songartist">Creator</label>
                    <select name="artistselect" id="songartist" class="selectinput">
                        <option selected value="<?= $artistid; ?>"><?= $artistname ?></option>
                    </select>
                </div>

                <div class="fileuploadform">
                    <label for="songAlbum">Media Collection <span class="required">*</span></label>
                    <select name="albumselect" id="songAlbum" required class="selectinput">
                        <option value="">Choose Album</option>
                        <?php foreach ($albums as $album) : ?>
                            <option value="<?= $album['id']; ?>"><?= $album['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="fileuploadform">
                    <label for="songGenre">Media Genre <span class="required">*</span></label>
                    <select id="songGenre" required class="selectinput">
                        <option value="">Choose Genre</option>
                        <?php foreach ($genres as $genre) : ?>
                            <option value="<?= $genre['id']; ?>"><?= $genre['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <input type="file" id="userfiles" class="upload-box" accept=".mp3, .wav" multiple type="file">

                <input type="button" value="Upload Files" onclick="uploadFiles()">

                <progress id="progressBar" value="0" max="100"></progress>

                <h6 id="status" style="white-space: pre-line; line-height: 2em;" wrap="hard"></h6>
                <p id="loaded_n_total"></p>

            </form>
        </div>
    </div>
