<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


    class Album {

        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;
        private $datecreated;
        private $description;

      

        public function __construct($con , $id) {
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
            $album = mysqli_fetch_array($query);


            if(mysqli_num_rows($query) < 1){
            
                $this->title = null;
                $this->id = null;
                $this->artistId = null;
                $this->genre = null;
                $this->artworkPath = null;
                $this->description = null;
                $this->datecreated = null;
            
            } else{                            
                $this->title = $album['title'];
                $this->id = $album['id'];
                $this->artistId = $album['artist'];
                $this->genre = $album['genre'];
                $this->datecreated = $album['datecreated'];
                $this->artworkPath = $album['artworkPath'];
                $this->description = $album['description'];
            }


        }

        public function getTitle(){

            return $this->title;
        }

        public function getId(){
            return $this->id;
        }

        public function getArtistId(){
            return $this->artistId;
        }

        public function getArtist(){

            return  new Artist($this->con, $this->artistId);
        }

        public function getArtworkPath(){

            return $this->artworkPath;
        }

        public function getDatecreated(){

            $phpdate = strtotime($this->datecreated);
            $mysqldate = date('d M Y', $phpdate);

            return $mysqldate;
        }

        public function getDescription(){

            return $this->description;
        }

        public function getGenre(){

            return $this->genre;
        }

        public function getNumberOfSongs(){
            $query = mysqli_query($this->con, "SELECT album  FROM songs WHERE album='$this->id'");

            if(mysqli_num_rows($query) < 1){
                $numberofsongs = 0;
            } else {
                $numberofsongs = mysqli_num_rows($query);
            }


            return $numberofsongs;
        }

        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
            $array = array();

            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['id']);
            }

            return $array;
        }

        public function getSongPaths(){
            $query = mysqli_query($this->con, "SELECT path FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
            $array = array();

            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['path']);
            }

            return $array;
        }

    }