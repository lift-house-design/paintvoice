<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = 'site/index';
$route['sitemap.xml'] = 'site/sitemap_xml'; 
$route['robots.txt'] = 'site/robots'; 
$route['sitemap'] = 'site/sitemap'; 
$route['about'] = 'site/content/about'; 
$route['terms'] = 'site/content/terms'; 
$route['privacy'] = 'site/content/privacy'; 
$route['blog/(:num)'] = 'blog/index/$1';
$route['news_feed/(:num)'] = 'news_feed/index/$1';

// captcha images
$route['captcha/(:any)/(:any)/(:any)'] = 'site/captcha/$1/$2';

//google site verification
$route['google(:any).html'] = 'site/google_verification/$1'; 

// load content pages
require_once( __DIR__ .'/app2.php');
$mysqli = new mysqli(
	$config['database']['hostname'], 
	$config['database']['username'], 
	$config['database']['password'], 
	$config['database']['database']
);
$res = $mysqli->query('select name from content where type="page"');
if ($res) {
    
    while($row = $res->fetch_assoc())
        $route[$row['name']] = 'site/content/'.$row['name'];

}

$route['gallery'] = 'site/gallery';  
$route['news'] = 'news_feed/index';
$route['news/view/(:num)'] = 'news_feed/view/$1';
$route['contact'] = 'site/contact';
/*
require_once( __DIR__ .'/../../system/database/DB.php');

$db =& DB();

$res = $db->select('name')->where('type!="aside"')->get('content')->result();
/*foreach($res as $row)
{
    $route[$row['name']] = 'site/content/'.$row['name'];
}
*/
// image generator
//$route['image/((?!\.png).*)\.png'] = 'site/image/$1'; 

// (:any) example
//$route['search/(:any)'] = 'site/search/$1';

// regex example
//$route['((?!\-meaning\-definition).*)-meaning-definition'] = 'site/search/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */