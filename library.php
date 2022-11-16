<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    include("config/global.php");
    include("config/database.php");
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




?>
<!-- headerends -->

<?php

$albumQuery = mysqli_query($con, "SELECT * FROM albums  WHERE  artist='$artistid' ORDER BY datecreated DESC");

$albums_data = array();

if (mysqli_num_rows($albumQuery) != 0) {
    while ($row = mysqli_fetch_array($albumQuery)) {

        array_push($albums_data, $row);
    }
}



?>

<?php if ($albums_data) : ?>

    <div class="recently_added" style="margin: 1em 0;">
        <p class="subtitle">All Uploaded Media-  Sorted by Most Recent</p>
      
    </div>

    <div class="artist_cols">
        <div class="cols_listing">
            <?php
            foreach ($albums_data as $row) :

            ?>

                <?php
                $album = new Album($con, $row['id']);
                ?>


                <div class="cols_item" role='link' tabindex='0' onclick="openPage('selectedalbum.php?id=<?= $row['id'] ?>')">
                    <img loading="lazy" class="image" src="<?= $album->getArtworkPath() ?>">
                    <div class="albumlistinfo">
                        <h2><?= $album->getTitle() ?></h2>
                        <p><?= $album->getDatecreated() ?></p>
                    </div>
                </div>


            <?php endforeach ?>





        </div>
    </div>



<?php else :  ?>
    Working on Getting Featured Music Artists Curated for You
<?php endif ?>