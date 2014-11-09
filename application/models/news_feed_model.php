<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* For CMS */
class News_Feed_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'news_feed';
	}

	public function create($name, $content)
	{
		$this->db->insert('news_feed', array('name'=>$name,'content'=>$content));
	}

	public function get_all()
	{
		$res = $this->db->select('news_feed.*,user.first_name,user.last_name')->join('user', 'user.id = news_feed.author')->order_by('time','desc')->get('news_feed')->result_array();
		return $res;
	}

	public function get($id)
	{
		$res = $this->db
			->select('news_feed.*,user.first_name,user.last_name')
			->where('news_feed.id',$id)
			->join('user', 'user.id = news_feed.author')
			->order_by('time','desc')
			->get('news_feed')->row_array();
		return $res;
	}

	public function has_newer($id)
	{
		$res = $this->db
			->select('id')
			->where('news_feed.id > '.intval($id))
			->get('news_feed')->row_array();
		return !empty($res);
	}
	public function has_older($id)
	{
		$res = $this->db
			->select('id')
			->where('news_feed.id < '.intval($id))
			->get('news_feed')->row_array();
		return !empty($res);
	}

	public function recent($start=0, $limit=10)
	{
		$res = $this->db
			->select('news_feed.*,user.first_name,user.last_name')
			->join('user', 'user.id = news_feed.author')
			->order_by('time','desc')
			->limit($limit,$start)
			->get('news_feed')->result_array();
		return $res;
	}
}