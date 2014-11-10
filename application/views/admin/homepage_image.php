<h1>Homepage Image</h1>
<?php if($this->input->post()): ?>
    <?php echo $this->upload->display_errors() ?>
<?php endif; ?>
<?php if($successful_upload): ?>
    <p>Your image was uploaded. You may need to refresh this page and/or the homepage before your image shows up.</p>
<?php endif; ?>
<h6>Preview</h6>
<div id="homepage-intro" class="parallax-img-container">
    <div class="parallax-img" data-anchor-target="#homepage-intro" data-top-bottom="transform:translateY(30%)" data-top="transform:translateY(-30%)"></div>
</div>
<h6>New Image</h6>
<p>For best results, your image should meet the following specifications:</p>
<ul>
    <li>Aspect ratio is close to 4:3</li>
    <li>Width is at least 1200px</li>
    <li>Height is at least 900px</li>
</ul>
<?php echo form_open_multipart() ?>
<table class="padded">
    <tr>
        <td>Upload Image</td>
        <td><?php echo form_upload(array(
            'name'=>'image',
            'value'=>set_value('image'),
        )) ?></td>
    </tr>
</table>
<div class="align-center">
    <?php echo form_submit('action','Upload New Image') ?>
</div>
<?php echo form_close() ?>
<script>
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
</script>