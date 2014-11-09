<?php
	function show_all_menus($area){
                $obj1 =& get_instance();
  		$obj1->load->helper('url');
                $menu = $obj1->db
			->select('content.name, content.title')
			->where('type','page')
                        ->where($area,'Yes')
			->order_by('weight','desc')
			->get('content')->result_array();
   
  		return $menu;
 	}
        
        function show_parent_menus($area){
                $obj1 =& get_instance();
  		$obj1->load->helper('url');
                $menu = $obj1->db
			->select('content.name, content.title')
			->where('type','page')
                        ->where($area,'Yes')
                        ->where('parent','0')
			->order_by('weight','desc')
			->get('content')->result_array();
   
  		return $menu;
 	}
        
        function show_child_menus($area, $parent){
                $obj1 =& get_instance();
  		$obj1->load->helper('url');
                $menu = $obj1->db
			->select('content.name, content.title')
			->where('type','page')
                        ->where($area,'Yes')
                        ->where('parent',$parent)
			->order_by('weight','desc')
			->get('content')->result_array();
   
  		return $menu;
 	}
?> 