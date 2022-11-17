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

            $('.uploadoverview').css('display', 'grid');
            $('#progressBar').css('display', 'block');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.open("POST", "parser");
            ajax.send(formdata);
        }



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

$sqlalbum = "SELECT id, title From albums WHERE artist='$artistid'";
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
        <h5>Album</h5>
        <p style="font-size: 0.7em;color: #8b7097;">Create & Manage Album </p>
        <!-- <h5>EP (Extended Play) Creation Form</h5> -->

    </div>
    <div class="manage_add_create">

    <div class="statistics">
                    <div onclick="openPage('uploadcollection?tag=music')" class="card" style="background: #560083; color: #fff;">
                        <div class="illustration">
                            <img src="images/fluent_data-treemap-20-filled.svg" alt="">
                        </div>
                        <div class="stats">
                                <p class="label" style="color: #fff">New Album</p>
                        </div>

                    </div>
                    <div onclick="openPage('uploadmedia?tag=music')" class="card" style="background:#0d4e4e">
                        <div class="illustration">
                            <img src="images/fontisto_shopping-basket.svg" alt="">
                        </div>
                        <div class="stats">
                            <p class="label" style="color: #fff">Add Tracks to Album</p>
                        </div>
                    </div>



                </div>

    </div>
</div>