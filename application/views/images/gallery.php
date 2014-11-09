<!DOCTYPE html>
<html>
    <head>
        <title>Gallery</title>

        <!-- the javascript code to load clicked image and changing the class-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorbox.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.colorbox.js"></script>
        <script>
            $(document).ready(function() {
                //Examples of how to assign the Colorbox event to elements
                $(".group1").colorbox({rel: 'group1'});

            });
            </script>
        </head>
        <body>
        
            <?php /*foreach ($images as $key => $img) { ?>
                        <!--<p><a class="group1" href="<?php echo base_url() . $dir['original'] . $img['original']; ?>" title="Me and my grandfather on the Ohoopee.">Grouped Photo 1</a></p>-->
                        <a class="group1" href="<?php echo base_url() . $dir['original'] . $img['original']; ?>" >
                            <img class="thumb" name="thumb" id="thumb_<?php echo $key; ?>" src="<?php echo base_url() . $dir['thumb'] . $img['thumb']; ?>"/>
                        </a>
            <?php }*/ ?>

        </body>
    </html>