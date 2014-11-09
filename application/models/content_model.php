<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* For CMS */
class Content_model extends App_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function update($data)
	{
		$old_name = $data['old_name'];
		unset($data['old_name']);


		if(empty($data['name']))
			$data['name'] = $old_name;
		$data['name'] = strtolower($data['name']);
		$data['name'] = preg_replace('/[^a-z0-9-_]/','_',$data['name']);
		$this->unfuck_wysiwyg($data['content']);

		if($old_name !== $data['name'])
		{
			$res = $this->db->where('name',$data['name'])->select('name')->get('content')->row_array();
			if($res)
				throw new Exception("Page '{$data['name']}' already exists");
		}
		
		$res = $this->db->where('name', $old_name)->update('content', $data);
	}

	public function insert($data)
	{
		$data['name'] = strtolower($data['name']);
		$data['name'] = preg_replace('/[^a-z0-9-_]/','_',$data['name']);
		$this->unfuck_wysiwyg($data['content']);

		$res = $this->db->where('name',$data['name'])->select('name')->get('content')->row_array();
		if($res)
			throw new Exception("Page '{$data['name']}' already exists");
		
		$res = $this->db->insert('content', $data);
	}

	public function delete($name)
	{
		$this->db->where('name',$name)->where('type','page')->delete('content');
	}

	public function get($name)
	{
		$res = $this->db->where('name',$name)->select('content')->get('content')->row_array();
		if(!$res)
			return '';
		return $res['content'];
	}
        
        public function get_title($name)
	{
		$res = $this->db->where('name',$name)->select('title')->get('content')->row_array();
		if(!$res)
			return '';
		return $res['title'];
	}

	public function get_all()
	{
		$res = $this->db->get('content')->result_array();
		return $res;
	}

	public function get_pages()
	{
		$res = $this->db->select('name,footer,topbar')->get('content')->result_array();
		return $res;
	}

	public function get_meta($name)
	{
		$res = $this->db->where('name',$name)->select('title,description')->get('content')->row_array();
		if(!$res)
			return array();
		return $res;
	}

	public function unfuck_wysiwyg(&$content)
	{
		$content = preg_replace('/([\'";])\s*color\s*\:[^";\']+([\'";])/','$1$2',$content);
		$content = preg_replace('/([\'";])\s*mso\-[^\s:]+\s*\:[^";\']+([\'";])/','$1$2',$content);
	}

	public function get_nav_data()
	{
        $nav_data=array();

        $result=$this->db
            ->where(array(
                'type'=>'page',
                'topbar'=>'Yes',
                'parent'=>'0'
            ))
            ->select(array('name','title'))
            ->order_by('weight')
            ->get('content')
            ->result_array();

        foreach($result as $row)
        {
            $nav_data[ $row['name'] ]=array(
                'title'=>$row['title'],
                'children'=>array(),
            );

            if($this->uri->segment(1)==$row['name'])
            {
                $nav_data[ $row['name'] ]['selected']=TRUE;
            }

            $children_result=$this->db
                ->where(array(
                    'type'=>'page',
                    'topbar'=>'Yes',
                    'parent'=>$row['name'],
                ))
                ->select(array('name','title'))
                ->order_by('weight')
                ->get('content')
                ->result_array();

            foreach($children_result as $child_row)
            {
                $nav_data[ $row['name'] ]['children'][ $child_row['name'] ]=array(
                    'title'=>$child_row['title'],
                );

                if($this->uri->segment(1)==$child_row['name'])
                {
                    $nav_data[ $row['name'] ]['selected']=TRUE;
                    $nav_data[ $row['name'] ]['children'][ $child_row['name'] ]['selected']=TRUE;
                }
            }
        }

        return $nav_data;

		// return array(
  //           '/about'=>array(
  //               'title'=>'About',
  //               'children'=>array(
  //                   '/lifestyle-collection'=>array(
  //                       'title'=>'Lifestyle Collection',
  //                   ),
  //                   '/designer-collection'=>array(
  //                       'title'=>'Designer Collection',
  //                   ),
  //               ),
  //           ),
  //           '/where-we-build'=>array(
  //               'title'=>'Where We Build',
  //               'children'=>array(
  //                   '/old-palm'=>array(
  //                       'title'=>'Old Palm',
  //                   ),
  //               ),
  //           ),
  //           '/gallery'=>array(
  //               'title'=>'Gallery',
  //               'selected'=>TRUE,
  //           ),
  //           '/news'=>array(
  //               'title'=>'News',
  //           ),
  //           '/contact'=>array(
  //               'title'=>'Contact',
  //           ),
  //       );
	}

	public function get_footer_data()
	{
        $footer_data=array(
            array(),
            array(),
            array(),
        );

        $result=$this->db
            ->where(array(
                'type'=>'page',
                'footer'=>'Yes',
            ))
            ->select(array('name','title'))
            ->order_by('weight')
            ->get('content')
            ->result_array();

        // Add static items
        array_unshift($result,array(
            'name'=>'/',
            'title'=>'Home',
        ));
        array_push($result,array(
            'name'=>'http://lifthousedesign.com',
            'title'=>'Web Design',
        ));

        $per_col=floor( count($result)/3 );
        $cur_col=0;

        for($i=0;$i<count($result);$i++)
        {
            $row=$result[$i];

            $footer_data[$cur_col][]=anchor($row['name'],$row['title']);

            if($i+1 >= ($per_col*($cur_col+1)) && $cur_col != 2)
            {
                $cur_col++;
            }
        }

        return $footer_data;

		// return array(
  //           array(
  //               anchor('/','Home'),
  //               anchor('/about','About'),
  //               anchor('/gallery','Gallery'),
  //           ),
  //           array(
  //               anchor('/where-we-build','Where We Build'),
  //               anchor('/old-palm','Old Palm'),
  //           ),
  //           array(
  //               anchor('/news','News'),
  //               anchor('/contact','Contact'),
  //               anchor('http://www.lifthousedesign.com','Web Design'),
  //           ),
  //       );
	}
}