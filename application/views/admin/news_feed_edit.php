
<h2>Edit News Post</h2>
<form method="post" action="/admin/news_feed_edit/<?= $id ?>">
	<b>News Name</b>
	<input class="full" name="name" value="<?= $name ?>" type="text" placeholder="News Title"/>
	<br/><br/>
	<b>News Content</b>
	<textarea name="content"><?= $content ?></textarea>
	<input class="full" type="submit" value="Update News"/>
</form>
<style>html,body{min-width:20px}</style>