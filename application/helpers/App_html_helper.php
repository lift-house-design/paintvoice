<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function nav_active($page, $class=''){
	return strpos($_SERVER['REQUEST_URI'], $page) === 0 ? 'class="active '.$class.'"' : $class;
}



/* Uses minify library... make sure it's installed */
if(!function_exists('min_css'))
{
	function min_css($css)
	{
		$html='';
		$min_url = '/min/b=assets&f=';
		$min_urls = array();
		foreach($css as $file)
		{
			if(strpos($file,'//') === 0)
				$html .= '<link href="'.$file.'" rel="stylesheet" type="text/css"/>'."\n";
			elseif(strpos($file,'/') === 0)
				$min_urls[] = substr($file,1);
			else
				$min_urls[] = 'css/'.$file;
		}
		if(!empty($min_urls))
			$html .= '<link href="' . $min_url . join(',',$min_urls) . '" rel="stylesheet" type="text/css"/>'."\n";

		return $html;
	}
}

/* Uses minify library... make sure it's installed */
if(!function_exists('min_js'))
{
	function min_js($js)
	{
		$html='';
		$min_url = '/min/b=assets&f=';
		$min_urls = array();
		foreach($js as $file)
		{
			if(strpos($file,'//') === 0)
				$html .= '<script src="'.$file.'" type="text/javascript"></script>'."\n";
			elseif(strpos($file,'/') === 0)
				$min_urls[] = substr($file,1);
			else
				$min_urls[] = 'js/'.$file;
		}
		if(!empty($min_urls))
			$html .= '<script src="'.$min_url . join(',',$min_urls).'" type="text/javascript"></script>'."\n";

		return $html;
	}
}

/* 
	LessCSS should only be used for development. 
	Please compile your .less files before deployment, and make sure the less_css array is empty so that this function returns an empty string.
*/
if(!function_exists('less_css'))
{
	function less_css($css)
	{
		if(empty($css))
			return '';
		$html = '';

		foreach($css as $css_file)
		{
			$url = "/assets/less/" . $css_file;
			$html .= '<link href="'.$url.'" rel="stylesheet/less" type="text/css"/>'."\n";
		}
		$html .= '<script>less = {env: "development", poll: 10000};</script>'."\n";
		$html .= '<script src="/assets/less/less-1.6.1.min.js" type="text/javascript"></script>'."\n";
		$html .= '<script>less.watch()</script>'."\n";
		return $html;
	}
}



if(!function_exists('css'))
{
    function css($href,$prefix_url='')
    {
        if(is_array($href))
        {
            $css_html='';

            foreach($href as $css_href)
            {
                $css_html.=css($css_href,$prefix_url);
            }
        }
        else
        {
            $url=rtrim($prefix_url,'/').'/'.trim_slashes($href);
            $css_html='<link rel="stylesheet" href="'.$url.'" />';
        }

        return $css_html;
    }
}

if(!function_exists('js'))
{
    function js($src,$prefix_url='')
    {
        if(is_array($src))
        {
            $js_html='';

            foreach($src as $js_src)
            {
                $js_html.=js($js_src,$prefix_url);
            }
        }
        else
        {
            $url=rtrim($prefix_url,'/').'/'.trim_slashes($src);
            $js_html='<script src="'.$url.'"></script>';
        }

        return $js_html;
    }
}

if(!function_exists('asset'))
{
    function asset($path)
    {
        $CI=get_instance();
        $assets_path=$CI->config->item('assets_path','app');
        return rtrim($assets_path,'/').'/'.trim_slashes($path);
    }
}

if(!function_exists('asset_exists'))
{
    function asset_exists($path)
    {
        $path=ltrim(asset($path),'/');
        return file_exists($path) && is_file($path);
    }
}

if(!function_exists('navigation_menu'))
{
    /**
     * Builds a unordered list navigation menu using a nested list
     * as a submenu. The data parameter must be an associative array
     * structured like the example below:
     *
     *    $menu_data=array(
     *        '/about'=>array(
     *            'title'=>'About',
     *            'children'=>array(
     *                '/lifestyle-collection'=>array(
     *                    'title'=>'Lifestyle Collection',
     *                ),
     *                '/designer-collection'=>array(
     *                    'title'=>'Designer Collection',
     *                ),
     *            ),
     *        ),
     *        '/where-we-build'=>array(
     *            'title'=>'Where We Build',
     *            'children'=>array(
     *                '/old-palm'=>array(
     *                    'title'=>'Old Palm',
     *                ),
     *            ),
     *        ),
     *        '/gallery'=>array(
     *            'title'=>'Gallery',
     *            'selected'=>TRUE,
     *        ),
     *        '/news'=>array(
     *            'title'=>'News',
     *        ),
     *        '/contact'=>array(
     *            'title'=>'Contact',
     *        ),
     *    );
     *
     * Which might output an HTML menu like this:
     *
     *     <ul class="nav">
     *         <li><a href="#">About</a>
     *             <ul>
     *                 <li><a href="#">Lifestyle Collection</a></li>
     *                 <li><a href="#">Designer Collection</a></li>
     *             </ul>
     *         </li>
     *         <li class="selected"><a href="#">Where We Build</a>
     *             <ul>
     *                 <li><a href="#">Old Palm</a></li>
     *             </ul>
     *         </li>
     *         <li><a href="#">Gallery</a></li>
     *         <li><a href="#">News</a></li>
     *         <li><a href="#">Contact</a></li>
     *     </ul>
     *
     * @param array $data A structured associative array defining the menu
     * @param array|string $attrs An array or string defining an ID, class name, or both to assign to the menu
     * @return string An HTML navigation menu
     */
    function navigation_menu($data,$attrs='')
    {
        $html='';

        // Parse id and/or class name from parameter
        if(is_array($attrs))
        {
            $supported_attrs=array('id','class');
            $attr_str='';

            foreach($supported_attrs as $attr_name)
            {
                if(!empty($attrs[$attr_name]))
                {
                    $attr_str.=' '.$attr_name.'="'.$attrs[$attr_name].'"';
                }
            }
        }
        else
        {
            $attr_str=$attrs;
        }

        $attr_str=' '.trim($attr_str);

        // Begin building the menu
        $html='<ul'.$attr_str.'>';

        // Iterate over top-level links
        foreach($data as $uri=>$link_data)
        {
            $is_selected=( !empty($link_data['selected']) && $link_data['selected']==TRUE );
            $children=!empty($link_data['children']) ? $link_data['children'] : FALSE;
            
            $html.='<li'.( $is_selected ? ' class="selected"' : '' ).'>'.anchor($uri,$link_data['title']);

            // Iterate over sub-level links if they exist
            if($children)
            {
                $html.='<ul>';

                foreach($children as $child_uri=>$child_data)
                {
                    $html.='<li>'.anchor($child_uri,$child_data['title']).'</li>';
                }

                $html.='</ul>';
            }

            $html.='</li>';
        }

        $html.='</ul>';

        return $html;
    }
}

?>