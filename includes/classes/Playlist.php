<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class Playlist
{

	private $con;
	private $id;
	private $name;
	private $owner;
	private $coverart;




	public function __construct($con, $data)
	{
		$results = [];
		//code...
		if (!is_array($data)) {

			//data is a string
			$query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
			$data = mysqli_fetch_array($query);
		}

		if ($data) {
			$this->con = $con;
			$this->id = $data['id'];
			$this->name = $data['name'];
			$this->owner = $data['owner'];
			$this->coverart = $data['coverurl'];
		} else {

			echo "<p class='result slide-bck-center'>No Such Playlist Exists </p>";
			exit;
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getOwner()
	{
		return $this->owner;
	}


	public function getCoverimage()
	{
		return $this->coverart;
	}

	public function checkOwner()
	{
		$query = mysqli_query($this->con, "SELECT id, name FROM playlists WHERE id='$this->id' AND owner='$this->owner'");
		return mysqli_num_rows($query);
	}




	public function getNumberOfSongs()
	{
		$query = mysqli_query($this->con, "SELECT DISTINCT songId FROM playlistsongs WHERE playlistId='$this->id'");
		return mysqli_num_rows($query);
	}

	public function getSongIds()
	{
		$query = mysqli_query($this->con, "SELECT DISTINCT songId FROM playlistsongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
		$array = array();

		while ($row = mysqli_fetch_array($query)) {
			array_push($array, $row['songId']);
		}

		return $array;
	}

	public static function getPlaylistsDropdown($con, $username)
	{

		$dropdown = '<select class="item playlistname">
							<option value="">Add to Playlist</option>    
						';

		$query = mysqli_query($con, "SELECT id, name FROM playlists WHERE owner='$username'");

		while ($row = mysqli_fetch_array($query)) {
			$id = $row['id'];
			$name = $row['name'];
			$dropdown = $dropdown . "<option value='$id' >$name</option>";
		}

		return $dropdown . "</select>";
	}
}