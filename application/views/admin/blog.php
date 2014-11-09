
<h2>New Blog Post</h2>
<form method="post" action="/admin/blog_add">
	<b>Blog Name</b>
	<input class="full" name="name" value="<?= empty($name) ? '' : $name ?>" type="text" placeholder="Blog Title"/>
	<br/><br/>
	<b>Blog Content</b>
	<textarea name="content"><?= empty($content) ? '' : $content ?></textarea>
	<input class="full" type="submit" name="action" value="Post Blog"/>
</form>
<hr/>

<h2>Manage Posts</h2>
<form method="post">
	<? foreach($blogs as $i => $v){ ?>
		<div>
			<i><?= date('m/d/y H:i:s',strtotime($v['time'])) ?></i>
			| 
			<b>
				<a target="_blank" href="/blog/view/<?= $v['id'] ?>"><?= $v['name'] ?></a>
			</b>
			<a class="pad10l pull-right" href="/admin/blog_delete/<?= $v['id'] ?>">Delete</a>
			<a class="pull-right" href="/admin/blog_edit/<?= $v['id'] ?>">Edit</a>
		</div>
		<hr/>
	<? } ?>
</form>
<style>html,body{min-width:20px}</style>