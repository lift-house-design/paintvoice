<div class="content"><?php echo $content ?></div>
<?php if(isset($older) || isset($newer)): ?>
	<div class="pagination">
		<?php if(isset($older)): ?>
			<?php echo anchor('news/'.intval($older),'Older','class="older button"') ?>
		<?php endif; ?>
		<?php if(isset($newer)): ?>
			<?php echo anchor('news/'.intval($newer),'Newer','class="newer button"') ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
<div class="news-listing">
	<?php foreach($news as $news_data): ?>
		<article class="news-item">
			<header>
				<h2><?php echo $news_data['name'] ?></h2>
				<div class="date"><?php echo date('F d, Y', strtotime($news_data['time'])) ?></div>
			</header>
			<div class="content">
				<?php echo get_instance()->_parse_content($news_data['content'],$word_limit) ?>
			</div>
			<?php echo anchor('news/view/'.$news_data['id'],'Read More','class="button"') ?>
		</article>
	<?php endforeach; ?>
</div>
<?php if(isset($older) || isset($newer)): ?>
	<div class="pagination">
		<?php if(isset($older)): ?>
			<?php echo anchor('news/'.intval($older),'Older','class="older button"') ?>
		<?php endif; ?>
		<?php if(isset($newer)): ?>
			<?php echo anchor('news/'.intval($newer),'Newer','class="newer button"') ?>
		<?php endif; ?>
	</div>
<?php endif; ?>