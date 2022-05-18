<?php

    class Topchart {

        private $con;

        public function __construct($con) {
            $this->con = $con;
          
        }


        public function getTopSongIds(){
            $query = mysqli_query($this->con, "SELECT id FROM songs  ORDER BY  plays DESC LIMIT 10");
            $array = array();

            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['id']);
            }

            return $array;
        }

        

    }

?>