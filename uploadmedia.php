<?php

include("config/database.php");
include("config/global.php");
include("config/errorhandler.php");






?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YNG3P75VXH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-YNG3P75VXH');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../assets/images/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="../browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- favicon end  -->

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- end of bootstrap -->
    <link rel="stylesheet" href="mwonyacreate.css">

    <link rel="stylesheet" href="vanillaupload.css">

    <title>Mwonyaa Media Upload</title>
</head>

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

<body>

    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Mwonyaa Artist</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index">Home</a></li>

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
                    } else {
                        echo " ";
                    }

                    ?>


                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <?php
                    if (isset($_SESSION["name"])) {

                        echo "

                        <li><a href='logout' tite='Logout'><span class='glyphicon glyphicon-log-out'></span> Logout</a>
                        </li> ";
                    } else {
                        echo "
                        <li><a href='contentcreator'><span class='glyphicon glyphicon-user'></span> Sign Up</a></li>
                        <li><a href='login' tite='Login'><span class='glyphicon glyphicon-log-in'></span> Login</a>

                        </li>

                        ";
                    }


                    ?>

                </ul>
            </div>
        </div>
    </nav>
    <div id="loginbody">


        <div class="container">
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

    </div>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

</body>

</html>