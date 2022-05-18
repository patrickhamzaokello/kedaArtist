<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class SharedPlaylist
{

    private $con;
    private $playlistIDgot;




    public function __construct($con, $data)
    {
        $results = [];
        
        if ($data) {
            $this->con = $con;
            $this->playlistIDgot = $data;
        } else {

            echo "<p class='result slide-bck-center'>No Such Playlist Exists </p>";
            exit;
        }
    }



    



    function playlistCol(){

        $query = mysqli_query($this->con, "SELECT id, name, owner FROM playlists WHERE id='$this->playlistIDgot' AND status=2");

        while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $name = $row['name'];
            $owner = $row['owner'];
        }

        $playlistcollection ="
        <div class='albumlist' role='link' tabindex='0' onclick='openPage(\"playlist?id=" . $id . "\")'>
        
        <img src='assets/images/bg.jpg'>

                        <div class='albumlistinfo'>Title: "
                    . $name.
                    "</div> 
                     <div class='albumlistinfo'>Owner: "
                    . $owner.
                    "</div> 
                     
                    
                    </div>";
        

        return $playlistcollection;

    }

}