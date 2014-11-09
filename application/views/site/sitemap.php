<div class="w960 sitemap">
	<ul>
		<? foreach($urls as $u){ ?>
			<li><a href="<?= $u['url'] ?>"><h2><?= htmlentities($u['text']) ?></h2></a></li>
			<? if(!empty($u['children'])){ ?>
				<ul>
					<? foreach($u['children'] as $u2){ ?>
						<li><a href="<?= $u2['url'] ?>"><h3><?= htmlentities($u2['text']) ?></h3></a></li>
						<? if(!empty($u2['children'])){ ?>
							<ul>
								<? foreach($u2['children'] as $u3){ ?>
									<li><a href="<?= $u3['url'] ?>"><h4><?= htmlentities($u3['text']) ?></h4></a></li>
								<? } ?>
							</ul>
						<? } ?>
					<? } ?>
				</ul>
			<? } ?>
		<? } ?>
	</ul>
</div>