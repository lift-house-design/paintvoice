<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends App_Controller
{
	public $page_size = 100000;

	public function __construct()
	{
		$this->models[] = 'content';
		$this->models[] = 'blog';
		parent::__construct();

		$this->asides['notifications'] = 'asides/notifications';
		
		// use min_css and min_js when possible to load assets through minify
		//$this->min_js[] = 'application.js';		
		//$this->min_css[] = 'application.css';
		
		/*
			LessCSS should only be used for development. 
			When you are ready to deploy, compile your less files into css files.
			Then remove any included .less files so that less.js will not be loaded.
		*/
		//$this->less_css[] = 'application.less';
	}

	/* Ad hoc pages */

	public function index($start = 0)
	{
		$start = max(0, $start);
		$this->data['blogs'] = $this->blog->recent($start, $this->page_size);
		if(!empty($this->data['blogs']))
		{
			$oldest = $this->data['blogs'][count($this->data['blogs']) - 1];
			$newest = $this->data['blogs'][0];
			if($this->blog->has_older($oldest['id']))
				$this->data['older'] = $start + $this->page_size;
			if($this->blog->has_newer($newest['id']))
				$this->data['newer'] = $start - $this->page_size;
		}
	}

	public function view($id)
	{
		$this->data['blog'] = $this->blog->get($id);
	}
}