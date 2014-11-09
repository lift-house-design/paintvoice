<?php echo doctype('html5') ?>
<html lang="en">
<head>
    <?php echo $yield_head_tags ?>
</head>
<body<?php if($page): ?> id="<?php echo $page ?>"<?php endif; ?> class="<?php echo $uri_string.( $is_homepage ? ' homepage' : '' ) ?>">
    <div class="sticky-footer-wrapper">
        <?php if($is_homepage): ?>
            <div id="homepage-intro" class="parallax-img-container">
                <img class="logo" src="<?php echo asset('img/layout/logo-lg.png') ?>" alt="<?php echo $app_title ?>" title="<?php echo $app_title ?>" />
                <div class="parallax-img" data-anchor-target="#homepage-intro" data-top-bottom="transform:translateY(30%)" data-top="transform:translateY(-30%)"></div>
            </div>
        <?php elseif(asset_exists($page_header)): ?>
            <div id="page-header" class="parallax-img-container">
                <div class="parallax-img" data-anchor-target="#page-header" data-top-bottom="transform:translateX(-10%)" data-75-top="transform:translateX(0%)" style="background-image: url(<?php echo asset($page_header) ?>)"></div>
            </div>
        <?php endif; ?>
        <?php echo $yield_nav ?>
        <main id="layout-content">
            <?php echo $yield ?>
        </main>
        <div class="sticky-footer-push"></div>
    </div>
    <?php echo $yield_footer ?>
        <script>
        <?php if($is_homepage || $page_header): ?>
            function window_resize()
            {
                // If mobile
                if($(window).width()<=767)
                {
                    // If skrollr is enabled
                    if($('.skrollable').length)
                    {
                        // Disable skrollr
                        s.destroy();
                    }
                }
                // If desktop
                else
                {
                    // If skrollr is disabled
                    if(!$('.skrollable').length)
                    {
                        // Enable skrollr
                        s=skrollr.init({
                            smoothScrolling: true
                        });
                    }

                    // Reset show menu button to closed
                    $('#layout-nav .nav').css('left','');
                    $('#layout-nav .show-menu').removeClass('open');
                }
            }

            $(window_resize);
            $(window).resize(window_resize);
        <?php endif; ?>
        // Mobile menu
        var animate_duration=300,
            is_animating=false;

        $('.show-menu').on('click',function(){
            if(!is_animating)
            {
                is_animating=true;

                var $menu=$('#layout-nav .nav'),
                    $show_menu=$('#layout-nav .show-menu');

                // If menu is open
                if($show_menu.hasClass('open'))
                {
                    // Close it
                    $menu.animate({
                        left: '105%'
                    },{
                        duration: animate_duration,
                        complete: function(){
                            $show_menu.removeClass('open');
                            is_animating=false;
                        }
                    });
                }
                else
                {
                    // Open it
                    $menu.animate({
                        left: '50%'
                    },{
                        duration: animate_duration,
                        complete: function(){
                            $show_menu.addClass('open');
                            is_animating=false;
                        }
                    });
                }
            }
        });
        </script>
</body>
</html>