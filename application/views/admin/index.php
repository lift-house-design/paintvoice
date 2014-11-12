<div class="accordion">
	<h3>Social Media</h3>
	<div>
		<form method="post" id="social-media">
			<table class="full striped padded">
				<? foreach($social_media as $v){ ?>
					<tr>
						<td>
							<a href="javascript:void(0)" title="Provide links to your social media accounts."><b> <?= $v['label'] ?></b></a>
						</td>
						<td>
							<input type="text" class="full" name="<?= $v['name'] ?>" value="<?= $v['value'] ?>" placeholder="http://<?= $v['name'] ?>.com/LiftHouseDesign" type="text"/>
						</td>
					</tr>
				<? } ?>
			</table>
			<input class="full" type="submit" name="action" value="Save Social Media"/>
		</form>
	</div>

	<h3>Color Scheme</h3>
	<div>
		<form method="post" id="color-scheme">
			<table class="full striped padded">
				<? foreach($colors as $i => $v){ ?>
					<tr>
						<td>
							<a href="javascript:void(0)" title="Make sure these are valid CSS colors. You may need to refresh the home page to see your changes."><b><?= ucwords(str_replace('_',' ',$i)) ?></b></a>
						</td>
						<td>
							<div class="color-test" id="color-test-<?= $i ?>" style="background-color:<?= $v ?>"></div>
						</td>
						<td>
							<input type="text" onkeyup="test_color(<?= $i ?>)" onpaste="test_color(<?= $i ?>)" class="full" name="<?= $i ?>" value="<?= $v ?>" placeholder="#2f8faa" type="text"/>
						</td>
					</tr>
				<? } ?>
			</table>
			<input class="full" type="submit" name="action" value="Save Color Scheme"/>
		</form>
	</div>

	<h3>Website Configuration</h3>
	<div>
		<form method="post" id="website-config">
			<table class="full striped padded">
				<? foreach($configuration as $i => $v){ ?>
					<tr>
						<td>
							<a href="javascript:void(0)" title="<?= htmlentities($v['help']) ?>"><b><?= ucfirst($v['label']) ?></b></a>
						</td>
						<td>
							<input type="text" class="full" name="<?= $v['name'] ?>" value="<?= $v['value'] ?>" placeholder="<?= $v['example'] ?>" type="text"/>
						</td>
					</tr>
				<? } ?>
			</table>
			<input class="full" type="submit" name="action" value="Save Configuration"/>
		</form>
	</div>

	<h3>Content Management</h3>
	<div class="tabs">
		<ul>
			<? foreach($content as $i => $v){ ?>
				<li>
					<a href="#cms-tab-<?= $v['name'] ?>">
						<?= ucwords(str_replace('_', ' ', $v['name'])) ?>
					</a>
				</li>
			<? } ?>
			<li>
				<a href="#cms-tab-new-cms-page">
					+
				</a>
			</li>
		</ul>
		<? foreach($content as $i => $v){ ?>
			<div id="cms-tab-<?= str_replace(' ', '_', $v['name']) ?>">
				<form method="post">
					<input name="old_name" value="<?= $v['name'] ?>" type="hidden"/>
					<? $data = array(
						array(
							'Title',
							'<input name="title" value="'.htmlentities($v['title']).'" type="text" class="full align-left" placeholder="Page Title"/>'
						),
						array(
							'Description',
							'<input name="description" value="'.htmlentities($v['description']).'" type="text" class="full align-left" placeholder="My New Page"/>'
						),
					); ?>
					<? if($v['type'] === 'page'){
						$data[] = array(
							$base_url,
							$v['type'] !== 'page' ? '' : '<input name="name" value="'.$v['name'].'" type="text" class="full align-left" placeholder="page_url"/>'
						);
						$data[] = array(
							'Links',
							form_select(array('Yes'=>'Show in Footer','No'=>'Do not Show in Footer'), $v['footer'], 'footer', 'Footer?', 'class="w49pc align-center"') .
							form_select(array('Yes'=>'Show in Top Bar','No'=>'Do not Show in Top Bar'), $v['topbar'], 'topbar', 'Top Bar?', 'class="w49pc align-center pull-right"')
						);
					} ?>
					<?= html_table(
						$data,
						array(),
						'class="full striped padded"'
					) ?>
					<div class="spacer4"></div>
					<textarea name="content"><?= $v['content'] ?></textarea>
					<input class="full" type="submit" name="action" value="Save Content"/>
					<? if($v['type'] === 'page'){ ?>
						<input class="pull-right" style="color:red;width:68px;font-size:10px;padding:0px;height:18px;" type="submit" name="action" value="Delete Page"/>
					<? } ?>
				</form>
			</div>
		<? } ?>
		<div id="cms-tab-new-cms-page">
			<form method="post">
				<?= html_table(
					array(
						array(
							$base_url,
							'<input name="name" value="" type="text" class="full align-left" placeholder="page_url"/>'
						),
						array(
							'Title',
							'<input name="title" value="" type="text" class="full align-left" placeholder="Page Title"/>'
						),
						array(
							'Description',
							'<input name="description" value="" type="text" class="full align-left" placeholder="My New Page"/>'
						),
						array(
							'Links',
							form_select(array('Yes'=>'Show in Footer','No'=>'Do not Show in Footer'), '', 'footer', 'Footer?', 'class="w49pc align-center"') .
							form_select(array('Yes'=>'Show in Top Bar','No'=>'Do not Show in Top Bar'), '', 'topbar', 'Top Bar?', 'class="w49pc align-center pull-right"')
						)
					),
					array(),
					'class="full striped padded"'
				) ?>
				<div class="spacer4"></div>
				<textarea name="content"></textarea>
				<input class="full" type="submit" name="action" value="Add New Page"/>
			</form>
		</div>
	</div>

	<!--h3>Blog Management</h3>
	<div>
		<iframe class="clear" src="/admin/blog"></iframe>
	</div-->
    <h3>News Management</h3>
	<div>
		<iframe class="section" src="/admin/news_feed"></iframe>
	</div>
</div>
<h3> <a href="/admin/gallery">Manage Gallery</a> </h3>
<h3> <a href="/admin/homepage_image">Manage Homepage Image</a> </h3>
<h3> <a href="/admin/page_image">Manage Page Images</a> </h3>
<div class="spacer20"></div>

