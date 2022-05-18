<div class="content__right">

    <div class="topChart">

        <p>WEEKLY TOP 10 SONGS</p>

      
        <?php
        include("includes/queries/rightsidebarquery.php") ?>


        <?php if ($topSongsArray) : ?>


        <?php
            foreach ($topSongsArray as $row) :
            ?>


        <?php $albumSong = new Song($con, $row) ?>
        <?php $albumArtist = $albumSong->getArtist() ?>
        <?php $songAlbum = $albumSong->getAlbum() ?>


        <div class='chartSong'>

            <div class='chartSong__art'>

                <img src="<?= $songAlbum->getArtworkPath() ?>" />

            </div>

            <div class='chartElement'>

                <span class='chartSongName' role='link' tabindex='0'
                    onclick='openPage("song?id=<?= $albumSong->getId() ?>")'>
                    <?= $albumSong->getTitle() ?>
                </span>

                <span class=' ChartArtistName' role='link' tabindex='0'
                    onclick='openPage("artist?id=<?= $albumArtist->getId() ?>")'>
                    <?= $albumArtist->getName() ?>
                </span>

            </div>

        </div>

        <?php endforeach ?>


        <?php else :  ?>
        <p> Generating Weekly Top 10 Songs Curated for You</p>
        <?php endif ?>




    </div>


</div>