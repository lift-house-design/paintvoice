<? $b = $news_feed; ?>
<div class="blog-wrap">
	<a href="/news_feed/view/<?= $b['id'] ?>"><h1 class="blog-title"><?= $b['name'] ?></h1></a>
	<b class="blog-author"><?= $b['first_name'] ?> <?= $b['last_name'] ?></b>
	&mdash;
	<i class="blog-time"/><?= $b['time'] ?></i>
	<div class="blog-content"><?= $b['content'] ?></div>
</div>
<a href="/news_feed">&larr; Back to News</a>