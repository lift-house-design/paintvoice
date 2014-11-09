<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends App_Controller
{
    public function __construct()
                
	{
		$this->models[] = 'content';
		$this->models[] = 'blog';
        $this->models[] = 'news_feed';
		

		$this->asides['notifications'] = 'asides/notifications';
		
		$this->data=array_merge($this->data,array(
	        'dir' => array(
	            'original' => 'assets/uploads/original/',
	            'thumb' => 'assets/uploads/thumbs/'
	        ),
	        'total' => 0,
	        'images' => array(),
	        'error' => ''
	    ));

		parent::__construct();
	}

	/* Ad hoc pages */

	public function index()
	{
		$this->asides['contact'] = 'asides/contact';
		$this->data['content_home'] = $this->content->get('homepage');
		$this->data['blogs'] = $this->blog->recent(0,5);
	}

	/* * * * * * * * * * * * * * * * * * *
	 * Some cool functions worth saving. *
	 * * * * * * * * * * * * * * * * * * */

	// this was used for slang.org CMS pages. Should build a CMS system with it.
	public function content($page)
	{
		$this->data['content'] = $this->content->get($page);
        $this->title = $this->content->get_title($page);
		$this->data['page'] = $page;
		$this->data['page_header']='img/headers/'.$page.'.jpg';
		$meta = $this->content->get_meta($page);
		config_merge('meta',$this->meta);
	}

	public function contact()
	{
		$this->title='Contact';
        $this->data['page'] = 'contact';
        $this->data['page_header']='img/headers/contact.jpg';
		$this->data['content'] = $this->content->get('contact');
	//	$this->data['body_class'] = 'bg5';
		$this->load->library('valid');

		// validation rules
		$rules = array(
			array('name', 'fullname'),
			array('phone', 'phone'),
			array('email', 'email'),
			//array('contact_method', ''),
			array('message', '')
		);

		// did we get some datas?
		$post = $this->input->post();
		if(!$post) // nope
		{
			$this->valid->fill_empty($this->data, $rules);
			return;
		}
		$this->data['scroll_to'] = '#contact';
		$err = $this->valid->validate($post, $rules);

		/* bot check */
		if(!$err)
		{
			$err = 'Are you a robot?';
			foreach($post as $name => $val)
				if(stripos($name, '00') === 0 && strlen($name) == 42)
				{
					if($this->db->where('name',$name)->get('bot_check')->row_array())
					{
						$err = 'Your message has already been sent!';
						$post = array();
						$this->valid->fill_empty($this->data, $rules);
						break;
					}
					$k = 0;
					for($i = 0; $i < strlen($name); $i++)
						$k += $i * ord($name[$i]);
					unset($post[$name]);
					if($val == $k)
					{
						$err = '';
						if(rand(0,10) == 10)
							$this->db->query('delete from bot_check where time <  date_sub(now(), interval 7 day)');
						$this->db->insert('bot_check', array('name' => $name));
					}
				}
		}

		if($err)
		{
			$this->errors[] = $err;
			$this->data = array_merge($this->data, $post);
			return;
		}

		// send email
		$message = '';
		foreach($post as $i => $p)
			$message .= $this->valid->label($i) . ": $p <br/>";
		
		$what = send_email(
			'Message from '.$post['name'],
			$message,
			$this->config->item('contact_recipient')
		);
		$this->valid->make_empty($this->data, $rules);
		$this->notifications[] = 'Your message has been received! You will be contacted shortly.';
	}

    
    public function gallery($start = 0) {
		$this->title='Gallery';
        $this->data['page'] = 'gallery';
        $this->data['page_header']='img/headers/gallery.jpg';
		$this->data['content'] = $this->content->get('gallery');

		$this->css[]='plugins/fancybox2/jquery.fancybox.css';
		$this->js[]='plugins/fancybox2/jquery.fancybox.pack.js';

        try {

            $this->load->library('pagination');

            $c_paginate['base_url'] = site_url('image/index');
            $c_paginate['per_page'] = '999';
            $finish = $start + $c_paginate['per_page'];

            if (is_dir($this->data['dir']['thumb'])) {
                $i = 0;
                if ($dh = opendir($this->data['dir']['thumb'])) {
                    while (($file = readdir($dh)) !== false) {
                        // get file extension
                        $ext = strrev(strstr(strrev($file), ".", TRUE));
                        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                            if ($start <= $this->data['total'] && $this->data['total'] < $finish) {
                                $this->data['images'][$i]['thumb'] = $file;
                                $this->data['images'][$i]['original'] = str_replace('thumb_', '', $file);
                                $i++;
                            }
                            $this->data['total']++;
                        }
                    }
                    closedir($dh);
                }
            }

            $c_paginate['total_rows'] = $this->data['total'];

            $this->pagination->initialize($c_paginate);
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
	}

        
	// robots.txt generator
	public function robots()
	{
		$this->view = false;
		header("Content-type: text/plain; charset=utf-8"); 
		echo "Sitemap: " . $this->config->item('base_path') . "/sitemap.xml";

		// Do not index sites in development
		if($this->config->item('environment') !== 'production')
			echo "\nUser-agent: *\nDisallow: /";
	}

	// this is used to verify google webmaster tools
	public function google_verification($code)
	{
		$this->view = false;
		if(trim(strtolower($this->config->item('google_site_verification'))) === 'yes')
			echo "google-site-verification: google$code.html";
		else
			echo "Google Site Verification must be enabled through the administration page.";
	}

	public function _sitemap_urls()
	{
		$base_url = 'http://'.$_SERVER['HTTP_HOST'];

		// initialize home page as top of the pyramid
		$urls = array(
			array(
				'url' => $base_url,
				'text' => $this->config->item('title','meta'),
				'children' => array()
			)
		);

		// top level
		$top = array(
			'contact' => 'Contact',
			'sitemap' => 'Site Map'
		);

		// CMS pages
		$cms = $this->content->get_all();
		foreach($cms as $c)
		{
			if($c['type'] === 'aside') continue;
			$top[$c['name']] = $c['title'] ? $c['title'] : page_to_human($c['name']);
		}
		
		foreach($top as $page => $text)
		{
			$children = array();
			if($page == 'blog')
			{
				$blogs = $this->blog->get_all();
				foreach($blogs as $blog)
					$children[] = array(
						'url' => $base_url . '/blog/view/' . $blog['id'],
						'text' => $blog['name'],
						'children' => array()
					);
			}
			$urls[0]['children'][] = array(
				'url' => $base_url . '/' . $page,
				'text' => $text,
				'children' => $children
			);
		}

		return $urls;
	}

	public function _sitemap_flatten($urls, $priority=1)
	{
		$out = array();
		$yesterday = date('Y-m-d',time()-86400*2);
		$lastweek = date('Y-m-d',time()-86400*8);

		foreach($urls as $u)
		{
			$out[] = array(
				'loc' => $u['url'],
				'lastmod' => $yesterday,
				'changefreq' => 'daily',
				'priority' => $priority
			);
			if(!empty($u['children']))
			{
				$children = $this->_sitemap_flatten($u['children'],$priority - 0.1);
				$out = array_merge($out, $children);
			}
		}
		return $out;
	}

	public function sitemap_xml()
	{
		$this->view = false;
		$this->load->library('xml');

		$urls = $this->_sitemap_urls();
		$urls = $this->_sitemap_flatten($urls);

		header("Content-type: text/xml; charset=utf-8"); 
		echo $this->xml->get_sitemap($urls);
	}

	/* human readable sitemap */
	public function sitemap()
	{
		$this->data['urls'] = $this->_sitemap_urls();
	}

	/* write some text on an image (from slang.org) */
	public function image($word)
	{
		
		$this->view = false;
		/*
		$word = urldecode($word);
		// Set the content-type
		header('Content-Type: image/png');

		// Create the image
		$im = imagecreatefrompng ( 'assets/img/seo.png' );

		// font settings
		$font_size1 = 48;
		$font_size2 = 36;
		$font_angle = 0;
		$font_file = 'assets/fonts/Fondel.ttf';

		// Create some colors
		$grey = imagecolorallocate($im, 128, 128, 128);
		$black = imagecolorallocate($im, 0, 0, 0);
		 //imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
		//imagettfbbox ( float $size , float $angle , string $fontfile , string $text )
		//imagefilledrectangle($im, 0, 0, 399, 29, $white);

		// The text to draw
		$text1 = 'Meaning Of :';
		$text2 = $word;

		// calculate text position for center
		$bounds1 = imagettfbbox ( $font_size1, $font_angle, $font_file , $text1 );
		$bounds2 = imagettfbbox ( $font_size2, $font_angle, $font_file , $text2 );
		$x1 = 150 - $bounds1[2] / 2;
		$x2 = 150 - $bounds2[2] / 2;
		$y1 = 200;
		$y2 = 250;

		// Text with shadow
		imagettftext($im, $font_size1, $font_angle, $x1+1, $y1+1, $grey, $font_file, $text1);
		imagettftext($im, $font_size1, $font_angle, $x1, $y1, $black, $font_file, $text1);
		imagettftext($im, $font_size2, $font_angle, $x2+1, $y2+1, $grey, $font_file, $text2);
		imagettftext($im, $font_size2, $font_angle, $x2, $y2, $black, $font_file, $text2);

		imagepng($im);
		imagedestroy($im);
		*/
	}

	public function captcha($w, $h)
	{
		$this->load->model('captcha');
		// captcha word should be set before this is used. see captcha_model
		$this->view = false;
		$this->captcha->out(
			$this->captcha->get_word(),
			intval($w), 
			intval($h)
		);
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */