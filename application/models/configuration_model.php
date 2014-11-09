<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* For Client Configuration */
class Configuration_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function save($data)
	{
		foreach($data as $name => $value)
			$this->db->where('name',$name)->update('configuration',array('value'=>$value));
	}

	public function get($name)
	{
		/*
		$res = $this->db->where('name',$name)->select('content')->get('content')->row_array();
		if(!$res)
			return '';
		return $res['content'];
		*/
	}
	public function get_all()
	{
		$res = $this->db->get('configuration')->result_array();
		return $res;
	}

	public function load()
	{
		/* configuration table */
        $config = $this->get_all();
        foreach($config as $c)
        	if($c['value'] !== '')
        		$this->config->set_item($c['name'], $c['value']);

        /* social_media table */
        $social_media = $this->get_social_media();
        foreach($social_media as $i => $s)
        {
        	unset($social_media[$i]);
        	$social_media[$s['name']] = $s['value'];
        }
        config_merge('social_media', $social_media);
	}

	public function get_colors()
	{
		$colors = [];
		$file = file(__DIR__.'/../../assets/less/colors.less', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
		foreach($file as $f)
		{
			if(preg_match('/\@c(\d+)\:\s*([^;]+)/',$f,$match))
				$colors[$match[1]] = $match[2];
		}
		return $colors;
	}

	public function set_colors($data)
	{
		$file = '';
		foreach($data as $i => $v)
		{
			list($tmp, $i) = explode('-', $i);
			$file .= '@c'.$i.': '.$v.";\n";
		}
		file_put_contents(__DIR__.'/../../assets/less/colors.less', $file);
		exec('bash '.__DIR__.'/../../dev/deploy.sh', $out);
	}

	public function get_social_media()
	{
		//$social_media = array();
		$res = $this->db->get('social_media')->result_array();
		return $res;
	}

	public function set_social_media($data)
	{
		foreach($data as $name => $value)
			$this->db->where('name',$name)->update('social_media',array('value'=>$value));
	}
}