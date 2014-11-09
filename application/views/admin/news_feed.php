
<h2>New News Post</h2>
<form method="post" action="/admin/news_feed_add">
	<b>News Name</b>
	<input class="full" name="name" value="<?= empty($name) ? '' : $name ?>" type="text" placeholder="News Title"/>
	<br/><br/>
	<b>News Content</b>
	<textarea name="content"><?= empty($content) ? '' : $content ?></textarea>
	<input class="full" type="submit" name="action" value="Post News"/>
</form>
<hr/>

<h2>Manage News Posts</h2>
<form method="post">
	<? foreach($news as $i => $v){ ?>
		<div>
			<i><?= date('m/d/y H:i:s',strtotime($v['time'])) ?></i>
			| 
			<b>
				<a target="_blank" href="/news_feed/view/<?= $v['id'] ?>"><?= $v['name'] ?></a>
			</b>
			<a class="pad10l pull-right" href="/admin/news_feed_delete/<?= $v['id'] ?>">Delete</a>
			<a class="pull-right" href="/admin/news_feed_edit/<?= $v['id'] ?>">Edit</a>
		</div>
		<hr/>
	<? } ?>
</form>
<style>html,body{min-width:20px}</style>