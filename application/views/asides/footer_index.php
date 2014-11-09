<div id="footer" class="pad20 hidden">
	<a class="w100pc" href="javascript:skrollTo('#home')" title="<?= $meta['site_name'] ?>">
		<?= $meta['site_name'] ?>
	</a>
	<hr class="w100pc"/>
	<div class="w100pc hidden">
		<a class="w25pc" href="javascript:skrollTo('#about')" title="<?= $meta['site_name'] ?>">About</a>
		<a class="w25pc" href="javascript:skrollTo('#blog')" title="<?= $meta['site_name'] ?>">News</a>
		<a class="w25pc" href="javascript:skrollTo('#contact')" title="<?= $meta['site_name'] ?>">Contact</a>
		<!--a class="w25pc" href="/contact" title="Contact <?= $meta['site_name'] ?>">Contact</a-->
		<? if($logged_in){ ?>
			<a class="w25pc" href="/authentication/log_out">Logout</a>
		<? }else{ ?>
			<a class="w25pc" href="/authentication/log_in">Login</a>
		<? } ?>
	<hr class="w100pc"/>
	<a class="w100pc" target="_blank" href="https://lifthousedesign.com" title="Web Development">
		Web Design
	</a>
	</div>
	<? if(!empty($has_social_media)){ ?>
		<hr/>
		<div class="w100pc align-center hidden">
			<? foreach($social_media as $s){ ?>
				<? if(empty($s['value'])) continue; ?>
				<a target="_blank" href="<?= $s['value'] ?>" title="<?= $site_name . ' ' . $s['label'] ?>">
					<img src="/assets/img/<?= $s['name'] ?>.png" alt="<?= $s['label'] ?>"/>
				</a>
			<? } ?>
		</div>
	<? } ?>
</div>