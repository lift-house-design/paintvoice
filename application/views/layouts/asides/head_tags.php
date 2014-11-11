<?php

/*
| -------------------------------------------------------------------
|  Display the title tag.
| -------------------------------------------------------------------
*/
echo '<title>'.( empty($page_title) ? $app_title : $title ).'</title>';

/*
| -------------------------------------------------------------------
|  Merge layout-specific meta tags with user-specified ones.
| -------------------------------------------------------------------
*/
echo meta(array_merge(array(
    array(
        'name'=>'Content-type',
        'content'=>'text/html; charset=utf-8',
        'type'=>'equiv',
    ),
    array(
        'name'=>'X-UA-Compatible',
        'content'=>'IE=edge,chrome=1',
        'type'=>'equiv',
    ),
    array(
        'name'=>'viewport',
        'content'=>'width=device-width, initial-scale=1',
    ),
),$meta));

/*
| -------------------------------------------------------------------
|  Include stylesheets.
| -------------------------------------------------------------------
*/
echo css($css,$asset_path);

echo '<link rel="shortcut icon" href="/assets/img/layout/favicon.png">';

/*
| -------------------------------------------------------------------
|  Include javascript.
| -------------------------------------------------------------------
*/
echo js($js,$asset_path);