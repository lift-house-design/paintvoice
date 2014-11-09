
<h2>Edit Blog Post</h2>
<form method="post" action="/admin/blog_edit/<?= $id ?>">
	<b>Blog Name</b>
	<input class="full" name="name" value="<?= $name ?>" type="text" placeholder="Blog Title"/>
	<br/><br/>
	<b>Blog Content</b>
	<textarea name="content"><?= $content ?></textarea>
	<input class="full" type="submit" value="Update Blog"/>
</form>
<style>html,body{min-width:20px}</style>