<div class="content"><?php echo $content ?></div>
<div class="gallery-listing">
    <?php foreach($images as $key => $img): ?>
        <?php echo anchor($dir['original'].$img['original'],img($dir['thumb'].$img['thumb']),'rel="gallery"') ?>
    <?php endforeach; ?>
</div>
<script>
    $(function(){
        $('.gallery-listing > a').fancybox();
    });
</script>