<?php $alignments=array('left','center','right') ?>
<footer id="layout-footer">
    <div class="wrapper">
        <?php echo anchor('/',$app_title,'class="back-to-top"') ?>
        <?php for($i=0;$i<3;$i++): ?>
            <div class="links align-<?php echo $alignments[$i] ?>">
            <?php foreach($footer_data[$i] as $link): ?>
                <?php echo $link ?>
            <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</footer>