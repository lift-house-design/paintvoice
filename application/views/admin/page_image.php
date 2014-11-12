<style>
    #has-image, #no-image {
        overflow: hidden;
    }
    #has-image {
        display: none;
    }
    #page-header {
        margin-top: 0;
        margin-bottom: 10px;
    }
</style>
<h1>Page Image</h1>
<?php
    if($action)
    {
        $errors='';
        ob_start();

        echo validation_errors();

        if($action=='Upload New Image')
        {
            echo $this->upload->display_errors();
        }

        $errors=ob_get_clean();

        if($errors)
        {
            echo $errors;
        }
        elseif($action=='Upload New Image')
        {
            echo '<p>The image was successfully uploaded. You may need to refresh your browser before you can see the image.</p>';
        }
        elseif($action=='Remove Image')
        {
            echo '<p>The image was successfully removed.</p>';
        }
    }
?>
<h6>Preview</h6>
<div id="has-image">
    <?php echo form_open(NULL,'id="remove-img"',array(
        'page'=>'',
    )) ?>
    <div id="page-header" class="parallax-img-container">
        <div class="parallax-img" data-anchor-target="#page-header" data-top-bottom="transform:translateX(-10%)" data-75-top="transform:translateX(0%)"></div>
    </div>
    <div class="align-center"><?php echo form_submit('action','Remove Image') ?></div>
    <?php echo form_close() ?>
</div>
<p id="no-image">There is no image for this page.</p>
<h6>Add/Change Image</h6>
<p>For best results, your image should meet the following specifications:</p>
<ul>
    <li>Aspect ratio is close to 3:1</li>
    <li>Width is at least 900px</li>
    <li>Height is at least 300px</li>
</ul>
<?php echo form_open_multipart(NULL,'id="change-img"') ?>
<table class="padded">
    <tr>
        <td>Page</td>
        <td><?php echo form_dropdown('page',array_merge($pages,array(''=>'(select a page)')),set_value('page')) ?></td>
    </tr>
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
    images=<?php echo json_encode($images) ?>;

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
        }
    }

    $(window_resize);
    $(window).resize(window_resize);

    // Admin page Javascript
    $(function(){
        $('#change-img select[name="page"]').on('change',function(){
            var page=$(this).val();
            
            if(page)
            {
                if(images.indexOf(page)!==-1)
                {
                    $('#has-image input[name="page"]').val(page);
                    $('#has-image .parallax-img').css('background-image','url(/assets/img/headers/'+page+'.jpg)')

                    $('#no-image').hide();
                    $('#has-image').show();

                    window_resize();
                }
                else
                {
                    $('#has-image').hide();
                    $('#no-image').show();
                }
            }
        });
    });
</script>