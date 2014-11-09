<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* For CMS */
class Blog_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'blog';
	}

	public function create($name, $content)
	{
		$this->db->insert('blog', array('name'=>$name,'content'=>$content));
	}

	public function get_all()
	{
		$res = $this->db->select('blog.*,user.first_name,user.last_name')->join('user', 'user.id = blog.author')->order_by('time','desc')->get('blog')->result_array();
		return $res;
	}

	public function get($id)
	{
		$res = $this->db
			->select('blog.*,user.first_name,user.last_name')
			->where('blog.id',$id)
			->join('user', 'user.id = blog.author')
			->order_by('time','desc')
			->get('blog')->row_array();
		return $res;
	}

	public function has_newer($id)
	{
		$res = $this->db
			->select('id')
			->where('blog.id > '.intval($id))
			->get('blog')->row_array();
		return !empty($res);
	}
	public function has_older($id)
	{
		$res = $this->db
			->select('id')
			->where('blog.id < '.intval($id))
			->get('blog')->row_array();
		return !empty($res);
	}

	public function recent($start=0, $limit=10)
	{
		$res = $this->db
			->select('blog.*,user.first_name,user.last_name')
			->join('user', 'user.id = blog.author')
			->order_by('time','desc')
			->limit($limit,$start)
			->get('blog')->result_array();
		return $res;
	}
}