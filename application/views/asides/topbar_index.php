<div id="topbar" class="skrollable skrollable-between">
    <div class="content-wrap2">
    <a class ="logo" href="/">
        <img  src="/assets/img/logo.png" alt="<?= $meta['site_name'] ?>"/>
    </a>
    <?php
    // showing parent menu and in nested loop chil menus been rendered
    $items = show_parent_menus("topbar");
    $menu = "<ul class='mainmenu'>";
    foreach ($items as $item) {
        $children = show_child_menus("topbar", $item['name']);
        $menu .= "<li class ='parent'>";
        $menu .= anchor($item['name'], $item['title']);
        if (isset($children)) {
            $menu .= "<ul class ='children'>";
            foreach ($children as $child) {
                $menu .= "<li class ='child'>";
                $menu .= anchor($child['name'], $child['title']);
                $menu .= "</li>";
            }
            $menu .= "</ul>";
        }
        
        
       
        
        $menu .= "</li>";
    }
    $menu .= "<li class ='parent'>".anchor("news_feed", 'News')."</li>";
    $menu .= "<li class ='parent'>".anchor("contact", 'Contact')."</li>";
    $menu .= "</ul>";

    echo $menu
    ?>          
</div>
</div>  