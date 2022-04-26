<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    include("../includes/config.php");
    include("../includes/classes/User.php");
    include("../includes/classes/Artist.php");
    include("../includes/classes/Album.php");
    include("../includes/classes/Song.php");
    include("../includes/classes/Playlist.php");
    include("../includes/classes/LikedSong.php");
    $db = new Database();
    $con = $db->getConnString();

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


if (isset($_GET['id'])) {
    $albumId =  $_GET['id'];
} else {
    header("Location:index.php");
}

$album = new Album($con, $albumId);
$artist = $album->getArtist();

?>
<!-- headerends -->

<div class="pagesection">

    <div class="overview__albums__head">

        <span class="section-title">Album</span>



    </div>

    <div class="entityInfo">
        <div class="leftSection">
            <img src="<?php echo $album->getArtworkPath(); ?>">
        </div>

        <div class="rightSection">
            <h2><?php echo $album->getTitle(); ?></h2>

            <p>ARTIST: <?php echo $artist->getName(); ?></p>

            <p> <?php echo $album->getNumberOfSongs(); ?> Songs</p>

            <button class="button rename" onclick="renamealbum('<?php echo $albumId; ?>')">Rename</button>
            <button class="button delete"
                onclick="deleteAlbum('<?php echo $albumId; ?>','<?php echo $album->getArtworkPath(); ?>')">Delete</button>

            <!-- <button class="button rename" onclick="changeartwork('<?php echo $albumId; ?>')">Edit Artwork</button> -->
            <a href="#popup1"> <button class="button rename">Change Artwork </button></a>


            <div id="popup1" class="overlay">
                <div class="popup">
                    <h4>Change Media Cover</h4>
                    <a class="close" href="#">&times;</a>
                    <div class="areacont">
                        <form enctype="multipart/form-data" method="post" id="upload_form">
                            <input name="filegroup" accept=".jpg, .png, .jpeg" class="coverimageinput" type="file">
                            <input type="button" class="uploadimagebtn" value="Upload Files" onclick="uploadFiles()">

                            <div class="uploadstatus">
                                <progress id="progressBar" value="0" max="100"></progress>

                                <h3 id="status"></h3>
                                <p id="loaded_n_total"></p>
                            </div>


                        </form>

                    </div>
                </div>
            </div>

            <script>
            var albumidgot = "<?php echo $albumId; ?>";

            function _(id) {
                return document.getElementById(id);
            }

            function uploadFiles() {
                var formdata = new FormData();
                var userfiles = document.getElementsByName("filegroup");
                for (var i = 0; i < userfiles.length; i++) {
                    var file = userfiles[i].files[0];
                    if (file) {
                        formdata.append("file_" + i, file);
                        // file.name (name | size | type)
                    }
                }

                formdata.append("albumidgot", albumidgot);

                formdata.append("username", "Patrick");

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.open("POST", "logic/changemediaartwork.php");
                ajax.send(formdata);
                location.reload();


            }

            function progressHandler(event) {
                _("loaded_n_total").innerHTML = "uploaded " + event.loaded + " bytes of " + event.total;
                var percent = (event.loaded / event.total) * 100;
                _("progressBar").value = Math.round(percent);
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
            }

            function completeHandler(event) {
                _("status").innerHTML = event.target.responseText;
                _("progressBar").value = 0;
                _("upload_form").reset();
            }
            </script>

        </div>
    </div>


    <div class="album">

        <div class='album__tracks'>

            <div class='tracks'>

                <div class='tracks__heading'>

                    <div class='tracks__heading__number'>#</div>

                    <div class='tracks__heading__title'>Song</div>

                    <div class='tracks__heading__length'>

                        <!-- <i class='ion-ios-stopwatch-outline'></i> -->
                        <i class="ion-levels"></i>

                    </div>

                    <div class='tracks__heading__popularity'>

                        <i class=' ion-ios-trash'></i>

                    </div>

                </div>

                <div class="track__collection">
                    <?php


                    $songIdArray = $album->getSongIds();

                    $i = 1;

                    foreach ($songIdArray as $songId) {

                        $albumSong = new Song($con, $songId);
                        $albumArtist = $albumSong->getArtist();

                        echo "
                                <div class='track'>

                                  <div class='track__number'>$i</div>
        
                                  <div class='track__added'>
        
                                    <i class='ion-play playsong '></i>

                                  </div>

                                  <div class='track__added'>

                                    <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                    <input type='hidden' class='artistId' value='" . $albumArtist->getId() . "'>


                                    <i class='ion-plus' ></i>
       
                                  </div>
        
                                  <div class='track__title featured' >
                                  
                                    <span class='title' >" . $albumSong->getTitle() . "</span>
                                    <span class='feature' value=\"" . $albumArtist->getId() . "\">" . $albumArtist->getName() . "</span>
                                    
                                  </div>
        
                                  <div class='track__more'>

                                     <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
          
                                    <i class='ion-more' onclick='showOptionsMenu(this)'></i>
          
                                  </div>
                                
                                  <div class='track__length'>" . $albumSong->getDuration() . "</div>


                                  
                                  <div class='track__popularity'  >
                                  <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                  
                                    <i class='ion-compose' onclick='renameAlbumsong(this, \"" . $albumId . "\" )'></i>
                                  </div>

                                  <div class='track__popularity' >
                                  <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                  
                                    <i class='ion-close-circled' onclick='deleteAlbumsong(this, \"" . $albumId . "\" )' ></i>
                                   
                                  </div>

                                    
        
                                </div> ";

                        $i = $i + 1;
                    }

                    ?>
                </div>





            </div>

        </div>

    </div>

</div>

<!-- options menu -->

<nav class="optionsMenu">
    <input type="hidden" class="songId">


    <div class="item" onclick="deleteAlbumsong(this, '<?php echo $albumId; ?>')">Delete Song</div>
    <div class="item" onclick="renameAlbumsong(this, '<?php echo $albumId; ?>')">Rename Song</div>



</nav>