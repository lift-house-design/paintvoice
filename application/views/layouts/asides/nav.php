<?php if($is_homepage): ?>
    <nav id="layout-nav" data-anchor-target="#homepage-intro" data-top="position:static;width:100%;" data-top-bottom="position:fixed;width:100%;top:0px"><!--  -->
<?php else: ?>
    <nav id="layout-nav" class="fixed">
<?php endif; ?>

    <div class="wrapper">
        <a class="logo" href="/"><?php echo $app_title ?></a>
        <a class="show-menu hide-on-desktop"><img src="<?php echo asset('img/layout/mobile-nav.png') ?>" alt="Show Menu" title="Show Menu" /></a>
        <?php echo navigation_menu($nav_data,array('class'=>'nav')) ?>
    </div>
</nav>