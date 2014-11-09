<? if(!empty($notifications)){ ?>
	<div class="notifications">
		<?= implode('<br/>',$notifications) ?>
	</div>
<? } ?>
<? if(!empty($errors)){ ?>
	<div class="errors">
		<?= implode('<br/>', $errors) ?> 
	</div>
<? } ?>