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
    $artistId =  $_GET['id'];
} else {
    header("Location:index");
}

$artist = new Artist($con, $artistId);

?>
<!-- headerends -->

<div class="artist__header"
    style="background-image: url('<?php echo $artist->getArtistCoverPath(); ?>'); background-size:cover; background-position:center">
    <div class="artistoverlay">
    </div>
    <div class="artist__info">

        <div class="profile__img">

            <img src="<?php echo $artist->getProfilePath(); ?>" />

        </div>

        <div class="artist__info__meta">

            <div class="artist__info__type">Artist</div>

            <div class="artist__info__name"><?php echo $artist->getName(); ?></div>

            <div class="artist__info__actions">

                <button class=" artistbutton button-dark" onclick="renameartistname('<?php echo $artistId; ?>')">
                    Edit Username
                </button>


                <a href="#changeprofileimage">
                    <button class="artistbutton button-light">
                        Profile Image
                    </button>
                </a>

                <a href="#changecoverimage">
                    <button class="artistbutton button-light">
                        Cover Image
                    </button>
                </a>





                <div id="changeprofileimage" class="overlay">
                    <div class="popup">
                        <h4>Change Profile Image</h4>
                        <a class="close" href="#">&times;</a>
                        <div class="areacont">
                            <form enctype="multipart/form-data" method="post" id="upload_form">
                                <input name="filegroup" accept=".jpg, .png, .jpeg" class="coverimageinput" type="file">
                                <input type="button" class="uploadimagebtn" value="Upload Files"
                                    onclick="changeprofileimage('<?php echo $artistId; ?>')">

                                <div class="uploadstatus">
                                    <progress id="progressBar" value="0" max="100"></progress>

                                    <h3 id="status"></h3>
                                    <p id="loaded_n_total"></p>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>

                <div id="changecoverimage" class="overlay">
                    <div class="popup">
                        <h4>Change Cover Image</h4>
                        <a class="close" href="#">&times;</a>
                        <div class="areacont">
                            <form enctype="multipart/form-data" method="post" id="upload_form">
                                <input name="filegroup" accept=".jpg, .png, .jpeg" class="coverimageinput" type="file">
                                <input type="button" class="uploadimagebtn" value="Upload Files"
                                    onclick="changecoverimage('<?php echo $artistId; ?>')">

                                <div class="uploadstatus">
                                    <progress id="progressBar" value="0" max="100"></progress>

                                    <h3 id="status"></h3>
                                    <p id="loaded_n_total"></p>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>




            </div>

        </div>


    </div>

    <div class="artist__listeners">

        <?php

        $totalplaysquery = mysqli_query($con, "SELECT SUM(`plays`) AS totalplays FROM songs where `artist` = '$artistId'");
        $row = mysqli_fetch_array($totalplaysquery);


        echo " <div class='artist__listeners__count'>" . $row['totalplays'] . "</div>  ";


        ?>

        <div class="artist__listeners__label">Total Streams</div>

    </div>



</div>

<div class="artist__content">

    <div class="tab-content">

        <!-- Overview -->
        <div role="tabpanel" class="tab-pane active" id="artist-overview">

            <div class="overview">

                <div class="overview__artist">

                    <!-- Latest Release-->
                    <div class="section-title">Latest Release</div>

                    <div class="latest-release">
                        <?php


                        $albumQuery = mysqli_query($con, "SELECT * FROM albums where artist='$artistId'ORDER BY id DESC LIMIT 1");

                        while ($row = mysqli_fetch_array($albumQuery)) {


                            echo "
                              <div class='latest-release__art' role='link' tabindex='0' onclick='openPage(\"album?id=" . $row['id'] . "\")'>

                                <img src='" . $row['artworkPath'] . "'/>
                               
                              </div>

                              <div class='latest-release__song'>

                              <div class='latest-release__song__title'>" . $row['title'] . "</div>


                                <div class='latest-release__song__date'>

                                  <span class='day'>12</span>

                                  <span class='month'>August</span>

                                  <span class='year'>2018</span>

                                </div>

                              </div>

                            
                            ";
                        }
                        ?>

                    </div>
                    <!-- / -->

                    <!-- Popular-->
                    <div class="section-title">Popular</div>

                    <div class="tracks">

                        <?php


                        $songIdArray = $artist->getSongIds();

                        $i = 1;



                        foreach ($songIdArray as $songId) {

                            if ($i > 5) {
                                break;
                            }

                            $albumSong = new Song($con, $songId);
                            $albumArtist = $albumSong->getArtist();

                            echo "
                          <div class='track'>

                            <div class='track__number'>$i</div>

                            <div class='track__added'>

                              <i class='ion-play playsong ''></i>

                            </div>

                            <div class='track__title featured'>
                            
                              <span class='title' onclick='setTrack(\"" . $albumSong->getId() . "\",tempPlaylist, true)'>" . $albumSong->getTitle() . "</span>
                              <span class='feature'>" . $albumArtist->getName() . "</span>
                              
                            </div>

                            <div class='track__more'>

                              <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
              
                              <i class='ion-more' onclick='showOptionsMenu(this)'></i>

                            </div>
                          
                            <div class='track__length'>" . $albumSong->getDuration() . "</div>
                            
                            <div class='track__popularity'>
                            
                              <i class='ion-arrow-graph-up-right'></i>
                              
                            </div>

                          </div> ";

                            $i = $i + 1;
                        }

                        ?>




                    </div>


                    <!-- options menu -->

                    <nav class="optionsMenu">
                        <input type="hidden" class="songId">

                        <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>


                    </nav>

                    <!-- / -->

                </div>




            </div>

        </div>
        <!-- / -->



    </div>

</div>