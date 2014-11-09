<article class="view news-item">
    <h1><?php echo $news_data['name'] ?></h1>
    <header>
        <div class="date"><?php echo date('F d, Y', strtotime($news_data['time'])) ?></div>
    </header>
    <div class="content">
        <?php echo get_instance()->_parse_content($news_data['content']) ?>
    </div>
    <?php echo anchor('news','Back to News','class="button"') ?>
</article>