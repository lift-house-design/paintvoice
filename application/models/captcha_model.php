<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Creates captcha images on the fly, stores captcha solution in session data
 */

class Captcha_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function is_set()
	{
		return strlen($this->get_word())>0;
	}

	public function set_word($word='')
	{
		$word = $word ? $word : $this->rand_word();
		$this->session->set_userdata('captcha_word', $word);
	}

	public function get_word()
	{
		return $this->session->userdata['captcha_word'];
	}

	public function validate($input)
	{
		if(!$this->is_set())
			return false;
		return trim(strtoupper($input)) === trim(strtoupper($this->get_word()));
	}

	public function rand_word($length=8)
	{
		$str = '';
		$pool = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		for ($i = 0; $i < $length; $i++)
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);

		return $str;
	}

	public function out($word='CAPTCHA', $width=300, $height=100, $colors=null)
	{
		//$img_path = __DIR__.'/../../assets/img/';
		$img_path = dirname(__FILE__).'/../../assets/img/';
		//$font_path = __DIR__.'/../../assets/fonts/Fondel.ttf';
		$font_path = dirname(__FILE__).'/../../assets/fonts/Fondel.ttf';
		// media options is running some old ass version of php that does not support __DIR__...
		$img_url = '/assets/img/';
		$width = $width ? $width : 300;
		$height = $height ? $height : $width / 3;
		$colors = $colors ? $colors : array(
			array( 0, 0, 155 ),
			array( 0, 155, 0 ),
			array( 155, 0, 0 ),
			array( 0, 155, 155 ),
			array( 155, 0, 155 )
		);

		$length	= strlen($word);

		// -----------------------------------
		// Determine angle and position
		// -----------------------------------

		$angle	= ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
		$x_axis	= rand(6, (360/$length)-16);
		$y_axis = ($angle >= 0 ) ? rand($height, $width) : rand(6, $height);

		// -----------------------------------
		// Create image
		// -----------------------------------

        $im = imagecreatetruecolor($width, $height);
        imagealphablending( $im, false );
        imagesavealpha( $im, true );
		$col=imagecolorallocatealpha($im,255,255,255,127);
		imagefilledrectangle($im,0,0,$width,$height,$col);

		// -----------------------------------
		//  Assign colors
		// -----------------------------------

		$bg_color		= imagecolorallocate ($im, 255, 255, 255);
		$border_color	= imagecolorallocate ($im, 0, 0, 0);
		$text_color		= imagecolorallocate ($im, 0, 245, 245);
		$grid_color		= imagecolorallocate($im, 245, 245, 245);
		$shadow_color	= imagecolorallocate($im, 0, 0, 0);
		foreach($colors as $i => $c)
			$colors[$i] = imagecolorallocate($im, $c[0], $c[1], $c[2]);

		// -----------------------------------
		//  Write the text
		// -----------------------------------
		imagealphablending($im, true);
		
		$min_font_size	= $width / $length / 1.7;
		$max_font_size	= $width / $length / 1.2;
		if($min_font_size < 8) $min_font_size = 8;
		$min_x = $max_font_size;
		$max_x =  $width - $length * $max_font_size;
		$x = rand($min_x, $max_x);

		$min_y = $height/2 - $max_font_size ;
		if($min_y < $max_font_size ) 
			$min_y = $max_font_size;
		
		$max_y = $height/2 + $max_font_size * 1.5;
		if($max_y > $height - $max_font_size/2) 
			$max_y = $height - $max_font_size/2;

		for ($i = 0; $i < strlen($word); $i++)
		{
			$color = $colors[array_rand($colors)];
			$font_size = rand($min_font_size, $max_font_size);
			$angle = rand(-30,30);
			$y = rand($min_y, $max_y);
			imagettftext($im, $font_size, $angle, $x, $y, $color, $font_path, substr($word, $i, 1));
			$x += $max_font_size;
		}

		// -----------------------------------
		//  Create the spiral pattern
		// -----------------------------------

		$theta		= 1;
		$radius		= 16;
		$circles	= $width/10;
		$points		= 4;
		$color = $colors[array_rand($colors)];

		for ($i = 0; $i < ($circles * $points) - 1; $i++)
		{
			//if(rand(1,10) == 1)
			$color = $colors[array_rand($colors)];
			imagesetthickness ($im, rand(1,$min_font_size/10));
			$thetac		= rand(4,5);
			$theta = $theta + $thetac;
			$rad = $radius * ($i / $points );
			$x = ($rad * cos($theta)) + $x_axis;
			$y = ($rad * sin($theta)) + $y_axis;
			$theta = $theta + $thetac;
			$rad1 = $radius * (($i + 1) / $points);
			$x1 = ($rad1 * cos($theta)) + $x_axis;
			$y1 = ($rad1 * sin($theta )) + $y_axis;
			imageline($im, $x, $y, $x1, $y1, $color);
			$theta = $theta - $thetac;
		}

		// -----------------------------------
		//  Output the image
		// -----------------------------------

		header('Content-Type: image/png');
		imagepng($im);
		imagedestroy($im);
	}
}