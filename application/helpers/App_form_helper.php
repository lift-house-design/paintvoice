<?php


function form_select($data, $val=false, $name='', $title=false, $attr='')
{
	if($title !== false)
		$attr .= ' data-placeholder="'.$title.'" placeholder="'.$title.'"';
	if($name)
		$attr .= ' name="'.$name.'"';
	
	// wrapper for hide/show chosen
	$html = "<span id=\"chosen-wrap-$name\">";

	$html .= "<select $attr>";
	
	$selected = empty($val) ? 'selected' : '';
	if($title !== false)
		$html .= "<option value=\"\" $selected disabled>$title</option>";
		//$html .= "<option value=\"\"></option>";
	
	foreach($data as $i => $s)
	{
		if(is_numeric($i))
			$i = $s;
		$selected = $i == $val ? 'selected' : '';
		$html .= "<option value=\"$i\" $selected>$s</option>";
	}
	return $html."</select></span>";
}

if(!function_exists('form_field'))
{
	function form_field($name,$label,$type='text',$options=array())
	{
		$CI=get_instance();

		$data=array_merge($options,array(
			'name'=>$name,
			'label'=>$label,
			'type'=>$type,
		));

		return $CI->load->view('asides/field',$data,TRUE);
	}
}

function set_missing(&$array, $indexes, $make_array=false)
{
	$array = empty($array) ? array() : $array;
	$array = is_array($array) ? $array : array($array);
	foreach(explode(',',$indexes) as $i)
	{
		if(!isset($array[$i]))
			$array[$i] = false;
		if($make_array && !is_array($array[$i]))
			$array[$i] = array();
	}
}