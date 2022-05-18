<?php

$songQuery = mysqli_query($con, "SELECT id FROM songs WHERE tag='music' ORDER BY weekplays DESC LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {

    array_push($resultArray, $row['id']);
}

if ($userRegstatus != "registered") {
    $adresultArray = array();
    $adsQuery = mysqli_query($con, "SELECT id FROM songs WHERE tag='ad' ORDER BY RAND() LIMIT 10");
    while ($row = mysqli_fetch_array($adsQuery)) {

        array_push($adresultArray, $row['id']);
    }
    $jsonAdsArray = json_encode($adresultArray);
} else {
    // userregistered
    $adresultArray = array();
    $jsonAdsArray = json_encode($adresultArray);
}




$jsonArray = json_encode($resultArray);


if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($con,  $_SESSION['userLoggedIn']);
    $currentuserID = $userLoggedIn->getUserId();
    $userrole = $userLoggedIn->getUserrole();

    echo "
    <script>
    currentuser = '$currentuserID';
    </script>";
} else {
    // header("Location: register");
    // header("Location:register?location=" . urlencode($_SERVER['REQUEST_URI']));

}


?>





<script>
    $(document).ready(function() {
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);


        $(".mutesvg").show();
        $(".unmutesvg").hide();

        $(".norepeatbtn").show();
        $(".repeatbtn").hide();

        $(".noshufflebtn").show();
        $(".shufflebtn").hide();

        updateVolumeProgressBar(audioElement.audio);

        // $(".current-track").on("mousedown touchstart mousemove touchmove ", function(e) {
        //     e.preventDefault();
        // });

        var audioitem = audioElement.audio;


        // if (audioitem) {
        //     window.addEventListener("keydown", function(event) {
        //         var key = event.which || event.keyCode;

        //         if (key === 32) {
        //             // spacebar  pause and play
        //             // eat the spacebar, so it does not scroll the page
        //             event.preventDefault();
        //             audioitem.paused ? playSong() : pauseSong();
        //         }
        //         if (key === 77) {
        //             // m - mute key
        //             event.preventDefault();
        //             audioitem.paused ? setMute() : setMute();
        //         }
        //         if (key === 78) {
        //             // n - next key
        //             event.preventDefault();
        //             audioitem.paused ? nextSong() : nextSong();
        //         }
        //         if (key === 80) {
        //             // p -  previous key
        //             event.preventDefault();
        //             audioitem.paused ? prevSong() : prevSong();
        //         }

        //         if (key === 82) {
        //             // r - repeat key
        //             event.preventDefault();
        //             audioitem.paused ? setRepeat() : setRepeat();
        //         }
        //         if (key === 83) {
        //             // s - shuffle key
        //             event.preventDefault();
        //             audioitem.paused ? setShuffle() : setShuffle();
        //         }

        //     });
        // }


        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e) {
            if (mouseDown) {
                timeFromOffset(e, this);
            }
        });


        $(".playbackBar .progressBar").mouseup(function(e) {
            timeFromOffset(e, this);

        });

        // volume bar updater when dragging.
        $(".control.volume .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".control.volume  .progressBar").mousemove(function(e) {
            if (mouseDown) {
                var percentage = e.offsetX / $(this).width();

                if (percentage >= 0 && percentage <= 1) {
                    audioElement.audio.volume = percentage;
                }

            }
        });

        $(".control.volume  .progressBar").mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();

            if (percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        });


        $(document).mouseup(function() {
            mouseDown = false;
        });

    });

    function timeFromOffset(mouse, progressBar) {

        var percentage = mouse.offsetX / $(progressBar).width() * 100;

        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function prevSong() {
        if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);

        } else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function serializeQuery(params, prefix) {
        const query = Object.keys(params).map((key) => {
            const value = params[key];

            if (params.constructor === Array)
                key = `${prefix}[]`;
            else if (params.constructor === Object)
                key = (prefix ? `${prefix}[${key}]` : key);

            if (typeof value === 'object')
                return serializeQuery(value, key);
            else
                return `${key}=${encodeURIComponent(value)}`;
        });

        return [].concat.apply([], query).join('&');
    }


    serialize = function(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }



    function songQueue() {
        //check if user is Registered
        var currentplayinglist = shuffle ? shufflePlaylist : currentPlaylist;

        //set cookie of current queue
        document.cookie = "track_queue=" + currentplayinglist.slice(currentIndex);
        //localway of passing values via the browser
        openPage("queue");
        return;

    }

    function songMixers() {

        //check if user is Registered
        if (isRegistered === "registered") {
            var currentsongplaying = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
            let lasttrackid = currentsongplaying;
            //set cookie of current songid
            document.cookie = "nowsong_id=" + lasttrackid;
            openPage("mwonyaamix?");
            return;
        } else {
            showPreviewDialog();
        }


    }



    function nextSong() {

        if (repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if (currentIndex == currentPlaylist.length - 1) {

            if (confirmmix != true) {
                showMwonyaamixdialog(confirmmix);
                console.log("showmix not true");
                return;
            } else {
                console.log("showmix true");
                if (confirmmix == true) {

                    var lasttrackid = currentPlaylist[currentIndex];
                    pauseSong();
                    $.post("includes/handlers/ajax/getSimilarSongJson.php", {
                        songId: lasttrackid
                    }, function(data) {

                        var recommededsongsarray = JSON.parse(data);

                        currentIndex = 0;

                        if (recommededsongsarray != "") {
                            shufflePlaylist = recommededsongsarray;
                            currentPlaylist = recommededsongsarray;

                            // let song mixer
                            // openPage("mwonyaamix?mix=" + lasttrackid);
                            // songMixers();

                            var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
                            setTrack(trackToPlay, currentPlaylist, true);

                            return
                        } else {
                            var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
                            setTrack(trackToPlay, currentPlaylist, true);
                        }


                    });

                    confirmmix = false;

                    return
                } else {
                    currentIndex = 0;

                    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
                    setTrack(trackToPlay, currentPlaylist, true);

                    return
                }
            }

        } else {
            if (isRegistered != "registered") {

                if (sessionsonglistencount % 5 == 0) {
                    showRegisterDialog();
                    var adsPlaylist = <?php echo $jsonAdsArray; ?>;
                    var songsPlaylist = shuffle ? shufflePlaylist : currentPlaylist;
                    var adsID = random_songid(adsPlaylist);
                    songsPlaylist.splice(currentIndex, 0, adsID);
                    setTrack(songsPlaylist[currentIndex], songsPlaylist, true);

                    const index = songsPlaylist.indexOf(adsID);
                    if (index > -1) {
                        songsPlaylist.splice(index, 1);
                    }

                } else {
                    currentIndex++;
                    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
                    setTrack(trackToPlay, currentPlaylist, true);
                }

            } else {
                currentIndex++;
                var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
                setTrack(trackToPlay, currentPlaylist, true);

            }

        }


    }


    function setRepeat() {
        repeat = !repeat;
        if (repeat) {
            $(".repeatbtn").show();
            $(".norepeatbtn").hide();
            console.log("repeat");


        } else {

            $(".norepeatbtn").show();
            $(".repeatbtn").hide();

            console.log("norepeat");

        }
    }

    function settings() {}


    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;


        if (audioElement.audio.muted) {
            $(".unmutesvg").show();
            $(".mutesvg").hide();
        } else {
            $(".mutesvg").show();
            $(".unmutesvg").hide();
        }
    }

    function setShuffle() {
        shuffle = !shuffle;

        if (shuffle) {
            $(".shufflebtn").show();
            $(".noshufflebtn").hide();
            console.log("shufflebtn");


        } else {

            $(".noshufflebtn").show();
            $(".shufflebtn").hide();

            console.log("noshufflebtn");

        }


        if (shuffle == true) {
            //randomize playlist
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

        } else {
            //shuffle is off and go back to regular playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

        }


    }

    function shuffleArray(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }


    function setTrack(trackId, newPlaylist, play) {


        if (newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if (shuffle == true) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }

        sessionsonglistencount++;

        pauseSong();

        $.post("includes/handlers/ajax/getSongJson.php", {
            songId: trackId
        }, function(data) {

            var track = JSON.parse(data);
            $(".playing__song__name").text(track.title);

            //queue songname
            $("#queuesongtitle").text(track.title);


            $.post("includes/handlers/ajax/getArtistJson.php", {
                artistId: track.artist
            }, function(data) {
                var artist = JSON.parse(data);
                $(".playing__song__artist").text(artist.name);
                $(".playing__song__artist").attr("onclick", "openPage('artist?id=" + artist.id + " ')");

                //queue songArtist
                $("#queuesongArtist").text(artist.name);


            });

            $.post("includes/handlers/ajax/getAlbumJson.php", {
                albumId: track.album
            }, function(data) {
                var album = JSON.parse(data);
                $(".playing__art img").attr("src", album.artworkPath);
                $(".playing__art img").attr("onclick", "openPage('album?id=" + album.id + "')");
                $(".playing__song__name").attr("onclick", "openPage('song?id=" + trackId + "')");

                //updatequeue
                $("#queueimage").attr("src", album.artworkPath);


            });

            audioElement.setTrack(track);

            if (play == true) {
                playSong();

            }

        });

    }


    function playSong() {

        if (audioElement.audio.currentTime == 0) {

            $.post("includes/handlers/ajax/updatePlays.php", {
                songId: audioElement.currentlyPlaying.id,
                userId: currentuser,
                userregstatus: isRegistered ? isRegistered : "notregistered"

            });

        }

        $(".ion-ios-play.play").hide();
        $(".current-track__actions .playbutton").hide();
        $(".ion-ios-pause.pause").show();
        $(".current-track__actions .pausebutton").show();

        $(".ion-ios-play.mainplay").hide();
        $(".mainplaybutton").hide();

        $(".ion-ios-pause.mainpause").show();
        $(".mainpausebutton").show();


        audioElement.play();
    }

    function pauseSong() {
        $(".ion-ios-play.play").show();
        $(".current-track__actions .playbutton").show();
        $(".ion-ios-pause.pause").hide();
        $(".current-track__actions .pausebutton").hide();
        $(".songviewimage").removeClass("spinitem");
        $(".ion-ios-play.mainplay").show();
        $(".mainplaybutton").show();

        $(".ion-ios-pause.mainpause").hide();
        $(".mainpausebutton").hide();

        audioElement.pause();
    }


    function random_songid(items) {

        return items[Math.floor(Math.random() * items.length)];

    }
</script>



<section class="current-track">

    <div class="current-track-wallpager">
        <div class="songplaying">

            <div class="lds-dual-ring"> </div>

            <div class="maxidicator heartbeat" onclick="playerView()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" />
                    <path d="M8 13.5L12 9.5L16 13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

            </div>

            <div class="playing__art">

                <img id="albumartworkbg" role='link' tabindex='0' src="" alt="Album Art" />

            </div>

        </div>


        <section class="playing">

            <div class="minimize heartbeat" onclick="minimize()">
                <svg width="449" height="449" viewBox="0 0 449 449" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="224.5" cy="224.5" r="224.5" fill="#C4C4C4" />
                    <path d="M215.454 346.528C220.726 351.8 229.274 351.8 234.546 346.528L320.459 260.615C325.732 255.342 325.732 246.795 320.459 241.523C315.187 236.251 306.64 236.251 301.368 241.523L225 317.89L148.632 241.523C143.36 236.251 134.813 236.251 129.541 241.523C124.268 246.795 124.268 255.342 129.541 260.615L215.454 346.528ZM211.5 111L211.5 336.982H238.5L238.5 111H211.5Z" fill="#310D6C" />
                </svg>
            </div>




        </section>

        <div class="current-track__actions">

            <!-- <a class="icon icon ion-ios-skipbackward" onclick="prevSong()"></a> -->
            <ion-icon class="ion-icon-withborder skiptrack" name="play-skip-back-outline" onclick="prevSong()"></ion-icon>
            <div class="playbutton">
                <a class="icon icon ion-ios-play play" onclick="playSong()"></a>
            </div>
            <div class="pausebutton">
                <a class="icon icon ion-ios-pause pause" onclick="pauseSong()"></a>
            </div>
            <ion-icon class="ion-icon-withborder skiptrack" name="play-skip-forward-outline" onclick="nextSong()"></ion-icon>
            <!-- <a class="icon ion-ios-skipforward" onclick="nextSong()"></a> -->

        </div>
    </div>




    <div class="progressBarversion2">

        <div class="middlebar">
            <div class="songmetatinfo">
                <div class="track-heading">
                    <div class="track-title">
                        <div class="marquee" dir="ltr">
                            <div class="marquee-wrapper">
                                <div class="playing__song">

                                    <span role='link' tabindex='0' class=" marquee playing__song__name"></span>

                                    - <span role='link' tabindex='0' class="playing__song__artist"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="track-actions">
                        <ul class="svg-icon-group">
                            <li class="svg-icon-group-item"><button class="svg-icon-group-btn" type="button" aria-label="View lyrics">
                                    <svg class="sk__sc-1vdzswr-0 bcVpWu" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 4.5C15 3.57174 14.6313 2.6815 13.9749 2.02513C13.3185 1.36875 12.4283 1 11.5 1C10.5717 1 9.6815 1.36875 9.02513 2.02513C8.36875 2.6815 8 3.57174 8 4.5C8 5.42826 8.36875 6.3185 9.02513 6.97487C9.6815 7.63125 10.5717 8 11.5 8C12.4283 8 13.3185 7.63125 13.9749 6.97487C14.6313 6.3185 15 5.42826 15 4.5V4.5ZM16 4.5C16 5.14155 15.8628 5.77568 15.5977 6.35987C15.3325 6.94406 14.9455 7.4648 14.4627 7.88718C13.9798 8.30955 13.4122 8.62379 12.7979 8.80882C12.1836 8.99385 11.5368 9.0454 10.901 8.96L3.048 15L0 12L7 4.42V4.5C7 3.30653 7.47411 2.16193 8.31802 1.31802C9.16193 0.474106 10.3065 0 11.5 0C12.6935 0 13.8381 0.474106 14.682 1.31802C15.5259 2.16193 16 3.30653 16 4.5V4.5ZM7.166 5.715L1.392 11.967L3.128 13.677L9.698 8.624C9.08707 8.35631 8.5431 7.95648 8.10527 7.45329C7.66745 6.95009 7.34665 6.35607 7.166 5.714V5.715Z" fill="white" />
                                    </svg>

                                </button></li>
                            <li class="svg-icon-group-item">
                                <div class="popper-wrapper"><button class="svg-icon-group-btn" type="button">
                                        <svg class="sk__sc-1vdzswr-0 bcVpWu" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 0H8V7H1V8H8V15H9V8H16V7H9V0Z" fill="white" />
                                        </svg>
                                    </button></div>
                            </li>
                            <li class="svg-icon-group-item"><button class="svg-icon-group-btn option-btn" type="button" aria-label="Remove from Favourite tracks">
                                    <svg class="sk__sc-1vdzswr-0 bcVpWu" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_104_30)">
                                            <path d="M8.00021 3.26598C2.83721 -2.68002 -2.56379 4.57798 1.32821 8.51598C5.22021 12.451 8.00021 15 8.00021 15C8.00021 15 10.7802 12.452 14.6722 8.51498C18.5642 4.50098 13.1622 -2.67902 8.00021 3.26498V3.26598Z" fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_104_30">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>


                                </button></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="playbackBar">

                <span class="progressTime current-track__progress__start">0.00</span>

                <div class="progressBar">

                    <div class="progressBarBg">

                        <div class="progressmade"></div>

                    </div>

                </div>

                <span class="progressTime current-track__progress__finish">0.00</span>
            </div>
        </div>

    </div>


    <div class="current-track__options">

        <ul class="option-list">
            <li class="option-item">
                <ul class="svg-icon-group">

                    <li class="svg-icon-group-item"><button class="svg-icon-group-btn" onclick="songMixers()" type="button" aria-label="Close">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 2H16C17.0609 2 18.0783 2.42143 18.8284 3.17157C19.5786 3.92172 20 4.93913 20 6V18C20 19.0609 19.5786 20.0783 18.8284 20.8284C18.0783 21.5786 17.0609 22 16 22H8C6.93913 22 5.92172 21.5786 5.17157 20.8284C4.42143 20.0783 4 19.0609 4 18V6C4 4.93913 4.42143 3.92172 5.17157 3.17157C5.92172 2.42143 6.93913 2 8 2V2ZM8 4C7.46957 4 6.96086 4.21071 6.58579 4.58579C6.21071 4.96086 6 5.46957 6 6V18C6 18.5304 6.21071 19.0391 6.58579 19.4142C6.96086 19.7893 7.46957 20 8 20H16C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18V6C18 5.46957 17.7893 4.96086 17.4142 4.58579C17.0391 4.21071 16.5304 4 16 4H8ZM12 19C10.6739 19 9.40215 18.4732 8.46447 17.5355C7.52678 16.5979 7 15.3261 7 14C7 12.6739 7.52678 11.4021 8.46447 10.4645C9.40215 9.52678 10.6739 9 12 9C13.3261 9 14.5979 9.52678 15.5355 10.4645C16.4732 11.4021 17 12.6739 17 14C17 15.3261 16.4732 16.5979 15.5355 17.5355C14.5979 18.4732 13.3261 19 12 19ZM12 17C12.7956 17 13.5587 16.6839 14.1213 16.1213C14.6839 15.5587 15 14.7956 15 14C15 13.2044 14.6839 12.4413 14.1213 11.8787C13.5587 11.3161 12.7956 11 12 11C11.2044 11 10.4413 11.3161 9.87868 11.8787C9.31607 12.4413 9 13.2044 9 14C9 14.7956 9.31607 15.5587 9.87868 16.1213C10.4413 16.6839 11.2044 17 12 17V17ZM8 5H12C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6V7C13 7.26522 12.8946 7.51957 12.7071 7.70711C12.5196 7.89464 12.2652 8 12 8H8C7.73478 8 7.48043 7.89464 7.29289 7.70711C7.10536 7.51957 7 7.26522 7 7V6C7 5.73478 7.10536 5.48043 7.29289 5.29289C7.48043 5.10536 7.73478 5 8 5V5ZM15 5H16C16.2652 5 16.5196 5.10536 16.7071 5.29289C16.8946 5.48043 17 5.73478 17 6V7C17 7.26522 16.8946 7.51957 16.7071 7.70711C16.5196 7.89464 16.2652 8 16 8H15C14.7348 8 14.4804 7.89464 14.2929 7.70711C14.1054 7.51957 14 7.26522 14 7V6C14 5.73478 14.1054 5.48043 14.2929 5.29289C14.4804 5.10536 14.7348 5 15 5V5ZM12 15C11.7348 15 11.4804 14.8946 11.2929 14.7071C11.1054 14.5196 11 14.2652 11 14C11 13.7348 11.1054 13.4804 11.2929 13.2929C11.4804 13.1054 11.7348 13 12 13C12.2652 13 12.5196 13.1054 12.7071 13.2929C12.8946 13.4804 13 13.7348 13 14C13 14.2652 12.8946 14.5196 12.7071 14.7071C12.5196 14.8946 12.2652 15 12 15V15Z" fill="white" />
                            </svg>


                        </button></li>

                    <li class="svg-icon-group-item"><button class="svg-icon-group-btn" onclick="songQueue()" type="button" aria-label="Chromecast">

                            <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6H28V8H10V6ZM10 12H28V14H10V12ZM15 18H28V20H15V18ZM10 24H28V26H10V24ZM4 14L11 19L4 24V14Z" fill="white" />
                            </svg>


                        </button></li>

                    <li class="svg-icon-group-item"><button class="svg-icon-group-btn repeatbtn" onclick="setRepeat()" type="button" aria-label="">

                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5H4C3.20435 5 2.44129 5.31607 1.87868 5.87868C1.31607 6.44129 1 7.20435 1 8C1 8.79565 1.31607 9.55871 1.87868 10.1213C2.44129 10.6839 3.20435 11 4 11H5.2V12H4C2.93913 12 1.92172 11.5786 1.17157 10.8284C0.421427 10.0783 0 9.06087 0 8C0 6.93913 0.421427 5.92172 1.17157 5.17157C1.92172 4.42143 2.93913 4 4 4H5V2L9 5ZM12 11C12.7956 11 13.5587 10.6839 14.1213 10.1213C14.6839 9.55871 15 8.79565 15 8C15 7.20435 14.6839 6.44129 14.1213 5.87868C13.5587 5.31607 12.7956 5 12 5H10.8V4H12C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12H11V14L7 11H12Z" fill="white" />
                            </svg>

                        </button>
                        <button class="svg-icon-group-btn norepeatbtn" onclick="setRepeat()" type="button" aria-label="">

                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5H4C3.20435 5 2.44129 5.31607 1.87868 5.87868C1.31607 6.44129 1 7.20435 1 8C1 8.79565 1.31607 9.55871 1.87868 10.1213C2.44129 10.6839 3.20435 11 4 11H5.2V12H4C2.93913 12 1.92172 11.5786 1.17157 10.8284C0.421427 10.0783 0 9.06087 0 8C0 6.93913 0.421427 5.92172 1.17157 5.17157C1.92172 4.42143 2.93913 4 4 4H5V2L9 5ZM12 11C12.7956 11 13.5587 10.6839 14.1213 10.1213C14.6839 9.55871 15 8.79565 15 8C15 7.20435 14.6839 6.44129 14.1213 5.87868C13.5587 5.31607 12.7956 5 12 5H10.8V4H12C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12H11V14L7 11H12Z" fill="white" />
                                <line x1="1.35355" y1="1.64645" x2="14.6967" y2="14.9896" stroke="white" />
                            </svg>

                        </button>
                    </li>
                    <li class="svg-icon-group-item"><button class="svg-icon-group-btn shufflebtn" onclick="setShuffle()" type="button" aria-label="">

                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 5L12 2V4H10V5H16ZM3.447 5.007C3.824 4.992 4.616 4.963 5.382 5.238C5.816 5.394 6.212 5.641 6.502 6.025C6.787 6.405 7 6.963 7 7.799C7 8.808 7.248 9.604 7.673 10.221C8.096 10.835 8.669 11.234 9.263 11.493C10.239 11.919 11.317 11.985 12 11.995V14L16 11H14V10.997H12.353C11.726 10.997 10.613 10.992 9.663 10.577C9.198 10.374 8.79 10.08 8.496 9.653C8.204 9.23 8 8.64 8 7.8C8 6.786 7.738 6.007 7.3 5.425C6.865 4.846 6.287 4.502 5.72 4.298C4.738 3.945 3.7 3.994 3.38 4.008C3.34 4.011 3.31 4.012 3.294 4.012H0V5.012H3.294L3.447 5.007ZM5 12H0V11H5V12Z" fill="#F6F021" />
                            </svg>

                        </button>

                        <button class="svg-icon-group-btn noshufflebtn" onclick="setShuffle()" type="button" aria-label="">

                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 5L12 2V4H10V5H16ZM3.447 5.007C3.824 4.992 4.616 4.963 5.382 5.238C5.816 5.394 6.212 5.641 6.502 6.025C6.787 6.405 7 6.963 7 7.799C7 8.808 7.248 9.604 7.673 10.221C8.096 10.835 8.669 11.234 9.263 11.493C10.239 11.919 11.317 11.985 12 11.995V14L16 11H14V10.997H12.353C11.726 10.997 10.613 10.992 9.663 10.577C9.198 10.374 8.79 10.08 8.496 9.653C8.204 9.23 8 8.64 8 7.8C8 6.786 7.738 6.007 7.3 5.425C6.865 4.846 6.287 4.502 5.72 4.298C4.738 3.945 3.7 3.994 3.38 4.008C3.34 4.011 3.31 4.012 3.294 4.012H0V5.012H3.294L3.447 5.008V5.007ZM5 12H0V11H5V12Z" fill="white" />
                            </svg>

                        </button>
                    </li>

                    <li class="svg-icon-group-item control volume"><button onclick="setMute()" class="svg-icon-group-btn mutesvg" type="button" data-testid="volume-mute" aria-expanded="false" aria-haspopup="true">

                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.894 9.8H2V6.2H5.894L9 3.301V12.7L5.894 9.8ZM1 10.8H5.5L10 15V1L5.5 5.2H1V10.8ZM15 7.655C15.0009 8.32932 14.8684 8.99715 14.6103 9.62011C14.3522 10.2431 13.9735 10.8089 13.496 11.285L12.809 10.557C13.5733 9.78468 14.0014 8.74158 14 7.655C14.0014 6.65885 13.6415 5.69599 12.987 4.945L13.695 4.237C14.5368 5.17632 15.0016 6.39369 15 7.655V7.655ZM12.906 7.763C12.906 8.547 12.576 9.253 12.049 9.753L11.362 9.026C11.5313 8.86676 11.6668 8.67512 11.7605 8.46247C11.8543 8.24982 11.9043 8.02049 11.9076 7.78813C11.911 7.55576 11.8676 7.32508 11.7801 7.10981C11.6925 6.89454 11.5626 6.69907 11.398 6.535L12.105 5.828C12.3593 6.08194 12.561 6.38358 12.6984 6.71564C12.8359 7.04769 12.9064 7.40362 12.906 7.763V7.763Z" fill="white" />
                            </svg>

                        </button>

                        <button onclick="setMute()" class="svg-icon-group-btn unmutesvg" type="button" data-testid="volume-unmute" aria-expanded="false" aria-haspopup="true">
                            <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M31 12.4099L29.59 10.9999L26 14.5899L22.41 10.9999L21 12.4099L24.59 15.9999L21 19.5899L22.41 20.9999L26 17.4099L29.59 20.9999L31 19.5899L27.41 15.9999L31 12.4099ZM18 29.9999C17.8677 29.9994 17.7368 29.9726 17.6149 29.9211C17.4931 29.8696 17.3826 29.7944 17.29 29.6999L9.67 21.9999H3C2.73478 21.9999 2.48043 21.8946 2.29289 21.7071C2.10536 21.5195 2 21.2652 2 20.9999V10.9999C2 10.7347 2.10536 10.4804 2.29289 10.2928C2.48043 10.1053 2.73478 9.99995 3 9.99995H9.67L17.29 2.29995C17.4774 2.1137 17.7308 2.00916 17.995 2.00916C18.2592 2.00916 18.5126 2.1137 18.7 2.29995C18.8884 2.48458 18.9962 2.73618 19 2.99995V28.9999C19 29.2652 18.8946 29.5195 18.7071 29.7071C18.5196 29.8946 18.2652 29.9999 18 29.9999ZM4 19.9999H10C10.2915 19.998 10.5732 20.105 10.79 20.2999L17 26.5699V5.42995L10.79 11.6999C10.5732 11.8949 10.2915 12.0019 10 11.9999H4V19.9999Z" fill="white" />
                            </svg>

                        </button>
                        <div class="progressBar">

                            <div class="progressBarBg">

                                <div class="volumeprogress"></div>

                            </div>

                        </div>

                    </li>

                </ul>
            </li>

        </ul>

    </div>

</section>