<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* For CMS */
class Ip_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'ip';
	}

	public function city_state_to_lat_long($city,$state)
	{
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($city)."&components=administrative_area:$state&sensor=false";
		$this->load->library('network');
		$res = $this->network->get($url);
		$res = json_decode($res,true);	
		if(empty($res['results'][0]['geometry']['location']))
			return array(0,0);
		return array_values($res['results'][0]['geometry']['location']);
	}

	public function locate($ip)
	{
		$url = "http://162.243.58.228:8008/json/$ip";
		$this->load->library('network');
		$res = $this->network->get($url);
		if(trim($res) == 'Not Found')
			return false;
		$res = json_decode($res,true);
		if(empty($res))
			return $this->locate_freegeoip($ip);
		if(!$res['latitude'])
			list($res['latitude'], $res['longitude']) = $this->city_state_to_lat_long($res['city'],$res['region_code']);
		return $res;
	}

	public function locate_freegeoip($ip)
	{
		$url = "https://freegeoip.net/json/$ip";
		$this->load->library('network');
		$res = $this->network->get($url);
		$res = json_decode($res,true);
		if(empty($res))
			return $this->locate_ipinfodb($ip);
		return $res;
	}

	public function locate_ipinfodb($ip)
	{
		$key = 'f057bb8d3ef2b465d7287c6cde31c5ab957a155b4584c4f94503813735ceb043';
		$url = "http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip&format=json";
		$this->load->library('network');
		$res = $this->network->get($url);
		$res = json_decode($res,true);
		if(empty($res['statusCode']))
			throw new Exception("network issue?\n\n$res");
		if($res['statusCode'] !== 'OK')
			throw new Exception('ipinfodb request failed: '.$res['statusMessage']);

		$states = states_array();
		return array(
			'ip' => $res['ipAddress'],
			'country_code' => $res['countryCode'],
			'country_name' => ucwords(strtolower($res['countryName'])),
			'region_code' => array_search(ucwords(strtolower($res['regionName'])), $states),
			'region_name' => ucwords(strtolower($res['regionName'])),
			'city' => ucwords(strtolower($res['cityName'])),
			'zipcode' => $res['zipCode'],
			'latitude' => floatval($res['latitude']),
			'longitude' => floatval($res['longitude']),
			'metro_code' => "",
			'areacode' => ""
		);
	}

}