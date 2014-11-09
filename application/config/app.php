<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Title Settings
| -------------------------------------------------------------------
| The site title and format of how you would like it the title to
| display.
*/
$config['app_title']='Tag Town';
$config['title_format']='{app_title} | {page_title}';

/*
| -------------------------------------------------------------------
|  Default Meta
| -------------------------------------------------------------------
| These are the default meta tags that are sent with every request
| unless different values are set.
*/
$config['default_meta']=array(
    // array(
    //     'name'=>'description',
    //     'content'=>'Welcome to the new standard in luxury home building. Where value and accountability meet style and sophistication.',
    // ),
    // array(
    //     'name'=>'keywords',
    //     'content'=>'couture,home,real estate,old palm,jupiter,florida',
    // ),
    array(
        'name'=>'copyright',
        'content'=>'Copyright '.date('Y').' Tag Town, All Rights Reserved',
    ),
    array(
        'name'=>'author',
        'content'=>'Nick Niebaum <nick@nickniebaum.com>',
    ),
);

/*
| -------------------------------------------------------------------
|  Asset Path
| -------------------------------------------------------------------
| The path leading to the assets directory that will be prefixed to
| any asset path.
*/
$config['assets_path']='/assets';