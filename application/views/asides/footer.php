
<div class="spacer100"></div>
<div id="footer" class="pad20 hidden">
    <div class="content-wrap2">
    <a class="w100pc" href="/#home" title="<?= $meta['site_name'] ?>">
        <?= $meta['site_name'] ?>
    </a>
    <hr class="w100pc"/>
    <div class="w100pc hidden">
        <div class="w33pc footerwraper first">
            <a class="w100pc"  href="/" alt=" Home <?= $meta['site_name'] ?>">Home</a>
            <a class="w100pc"  href="/aboutus" alt=" About <?= $meta['site_name'] ?>">About</a>
            <a class="w100pc"  href="/gallery" alt="Gallery<?= $meta['site_name'] ?>">Gallery</a>
        </div>
        <div class="w33pc footerwraper second">
            <a class="w100pc"  href="/where-we-build" alt="Where We Build <?= $meta['site_name'] ?>">Where We Build</a>
            <a class="w100pc"  href="/old-palm" alt="Old Palm<?= $meta['site_name'] ?>">Old Palm</a>
        </div>
        <div class="w33pc footerwraper third">
            <a class="w100pc"  href="/news_feed" alt="News<?= $meta['site_name'] ?>">News</a>
            <a class="w100pc" href="/contact" title=" Contact <?= $meta['site_name'] ?>">Contact</a>
            <a class="w100pc" href="https://lifthousedesign.com/" title="Web Design <?= $meta['site_name'] ?>">Web Design</a>
            <? if ($logged_in) { ?>
                <a class="w100pc" href="/authentication/log_out">Logout</a>
            <? } else { ?>
                <a class="w100pc" href="/authentication/log_in">Login</a>
            <? } ?> 
        </div>


    
    </div>
    <? if (!empty($has_social_media)) { ?>
        <hr/>
        <div class="w100pc align-center hidden">
            <? foreach ($social_media as $s) { ?>
                <? if (!empty($s['value'])) continue; ?>
                <a target="_blank" href="<?= $s['value'] ?>" title="<?= $site_name . ' ' . $s['label'] ?>">
                    <img src="/assets/img/<?= $s['name'] ?>.png" alt="<?= $s['label'] ?>"/>
                </a>
            <? } ?>
        </div>
    <? } ?>
   </div>      
</div>
