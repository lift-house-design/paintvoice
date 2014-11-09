<?
class Id3info
{
	public $getID3;
	public $info;
	public function __construct()
	{
		require_once(__DIR__.'/getID3-1.9.7/getid3/getid3.php');
		$this->getID3 = new getID3;
	}
	public function load($path)
	{
		if(!file_exists($path))
			throw new Exception("File not found: $path");

		$this->info = $this->getID3->analyze($path);
		getid3_lib::CopyTagsToComments($this->info);

		// fill missing data
		$name = $this->info['filename'];
		$period = strrpos($name,'.',-1);
		$name = substr($name,0,$period);
		if(stripos($name,' - ') !== false)
			list($artist, $title) = explode(' - ', $name);
		else
			list($artist, $title) = array($name, $name);
		if(empty($this->info['comments']['title']))
			$this->info['comments']['title'] = $title;
		if(empty($this->info['comments']['artist']))
			$this->info['comments']['artist'] = $artist;
		if(empty($this->info['comments']['album']))
			$this->info['comments']['album'] = $title;
		if(empty($this->info['comments']['track']))
			$this->info['comments']['track'] = 1;
	}
	public function picture()
	{
		if(empty($this->info['comments']['picture'][0]['data']))
			return false;
		else
			return array(
				'mime' => $this->info['comments']['picture'][0]['image_mime'],
				'data' => $this->info['comments']['picture'][0]['data']
			);
	}
	public function basic()
	{
		return array(
			'title' => $this->info['comments']['title'],
			'artist' => $this->info['comments']['artist'],
			'album' => $this->info['comments']['album'],
			'track' => $this->info['comments']['track']
		);
		//if(empty($info['comments']['title']))

			//'title' => $info['comments']['title'];

	}
	public function dump($path)
	{
		$info = $this->getID3->analyze($path);
		getid3_lib::CopyTagsToComments($info);
		//var_dump($info);
		echo '<pre>';
		var_dump($info);
		//var_dump($info['comments']);
		echo '</pre>';
		//header('Content-type: '.$info['comments']['picture'][0]['image_mime']);
		//echo $info['comments']['picture'][0]['data'];die;
		//var_dump( $info['comments']['picture'][0]);die;
	}
}
?>