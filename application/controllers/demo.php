<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* * * * * * * * * * * * * * * * * *\
 * Examples and Demos and Whatnots *
\* * * * * * * * * * * * * * * * * */
	
/* This class is for code examples and testing. *\
\*      It should not go into production.       */

class Demo extends App_Controller
{
	public function __construct()
	{
	//	$this->models[] = 'content';
		$this->models[] = 'ip';
		parent::__construct();

		$this->asides['notifications'] = 'asides/notifications';
		
		// use min_css and min_js when possible to load assets through minify
		$this->min_js[] = '/plugins/projekktor/projekktor-1.3.09.min.js';		
		$this->min_css[] = '/plugins/projekktor/themes/maccaco/projekktor.style.css';
		
		/*
			LessCSS should only be used for development. 
			When you are ready to deploy, compile your less files into css files.
			Then remove any included .less files so that less.js will not be loaded.
		*/
		//$this->less_css[] = 'application.less';
	}

	/* Ad hoc pages */

	public function index()
	{

	}

	public function pie(){}

	public function locate_city($city='Austin',$state='TX')
	{
		var_dump(
			$this->ip->city_state_to_lat_long($city,$state)
		);
		$this->view = false;
	}

	public function locate_ip($ip=false)
	{
		if(!$ip)
			$ip = $_SERVER['REMOTE_ADDR'];
		$this->data['ip'] = $ip;
		echo "$ip<hr/>";
		$start = microtime(true);
		$loc = $this->ip->locate($ip);
		?><h3>lifthouse server - <?= microtime(true) - $start ?> seconds</h3><pre><? var_dump($loc); ?></pre><?
		$start = microtime(true);
		$loc = $this->ip->locate_freegeoip($ip);
		?><h3>freegeoip - <?= microtime(true) - $start ?> seconds</h3><pre><? var_dump($loc); ?></pre><?
		$start = microtime(true);
		$loc = $this->ip->locate_ipinfodb($ip);
		?><h3>ipinfodb - <?= microtime(true) - $start ?> seconds</h3><pre><? var_dump($loc); ?></pre><?
		$this->view = false;
	}

	public function rdio()
	{
		$this->view = false;
		$oauth = new OAuth('h94wmsjgnkeq5pwpec7kpr52','cAP2a2ZGgE');
	}

	public function youtube()
	{

	}

	public function id3info()
	{
		$this->view = false;
		$this->load->library('id3info');
		$this->id3info->load(__DIR__.'/../../assets/audio/Al Johnson - I Only Have Eyes For You.mp3');
		$this->data['song'] = $this->id3info->basic();
        $this->data['song']['picture'] = $this->id3info->picture();
        echo '<pre>';var_dump($this->data['song']);
	}

	public function chosen()
	{
		$this->min_js[] = '/plugins/chosen/chosen.jquery.min.js';
		$this->min_css[] = '/plugins/chosen/chosen.min.css';
		
	}

	public function projekktor()
	{

	}

	public function live365()
	{

	}

	public function soundcloud()
	{

	}

	public function spotify()
	{

	}

}