<?php

class Recommendation
{

    private $con;
    private $userId;
    private $mostplayedsongs = array();



    public function __construct($con, $userId)
    {
        $this->con = $con;
        $this->userId = $userId;

        $query = mysqli_query($this->con, "SELECT * FROM frequency WHERE userid=$this->userId ORDER BY plays DESC LIMIT 10");

        if (mysqli_num_rows($query) == 0) {
            echo "
             
                            <div  class='noResults'>
                             <h5>Come Back again for Recommendations</h5>
                             <p>we recommend songs based on your prefferences and listening activities </p>
                            </div>
                 
                ";
            exit;
        }

        while ($row = mysqli_fetch_array($query)) {
            array_push($this->mostplayedsongs, $row['songId']);
        }

        return $this->mostplayedsongs;
    }


    public function getMostSongIds()
    {
        $query = mysqli_query($this->con, "SELECT * FROM frequency WHERE userid=$this->userId ORDER BY plays DESC LIMIT 10");

        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['songId']);
        }

        return $array;
    }

    public function getArtistIds()
    {
    }
}