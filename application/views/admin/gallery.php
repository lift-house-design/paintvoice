<!-- the javascript code to load clicked image and changing the class-->
<script type="text/javascript">
    function changepic(img_src, obj) {
        document["img_tag"].src = img_src;
        var thumbs = document.getElementsByName("thumb");
        for (var i = 0; i < thumbs.length; i++) {
            var tmp_id = "thumb_" + i;
            document.getElementById(tmp_id).setAttribute("class", "thumb");
        }
        document.getElementById(obj).setAttribute("class", "thumbclick");
        var ori_img = img_src.replace("thumb_", "");
        document.getElementById("detimglink").setAttribute("href", ori_img);
    }
</script>

<style>
    .imgbox{ display: block;
    float: left;
    padding: 10px;
    border: 1px solid #3b4e65;
    margin: 5px;}
    .clear{clear: both;}
</style>

<!-- the view file -->
<div id="container">
<!--    <div id="imgshow">
        <?php if (isset($images[0])) { ?>
            <a href="<?php echo base_url() . $dir['original'] . $images[0]['original']; ?>" target="_blank" id="detimglink">
                <img class="imgdet" name="img_tag" src="<?php echo base_url() . $dir['original'] . $images[0]['original']; ?>" width="500"/>
            </a>
        <?php } ?>
    </div>-->

    <div id="imglist">
        <form enctype="multipart/form-data" id="fupload" method="post" action="<?php echo site_url('admin/gallery'); ?>">
            <input name="userfile" type="file" size="20"/>
            <input type="submit" name="btn_upload" value="Upload &uarr;" class="btnupload"/>
            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
        </form>

        <div class="clear"></div>

        <div class="imgfor">
            <!-- Looping Array Image -->
            <?php foreach ($images as $key => $img) { ?>
                <div class="imgbox">
                    <div>
                        <a href="javascript:" onclick="changepic('<?php echo base_url() . $dir['original'] . $img['original']; ?>', 'thumb_<?php echo $key; ?>');">
                            <img class="thumb" name="thumb" id="thumb_<?php echo $key; ?>" src="<?php echo base_url() . $dir['thumb'] . $img['thumb']; ?>"/>
                        </a>
                    </div>
                    <div class="clear"></div>
                    <div class="dadel">
                        <a class="adel" href="<?php echo site_url('admin/gallery_img_delete/' . $img['original']); ?>">
                            delete
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>

        <div class="bottom">
            <?php echo $total; ?> Image(s)
        </div>

        <div class="bottom">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>

    <div class="clear"></div>

</div> <!-- end div container -->