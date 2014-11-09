<div class="align-center">
	<? if($password_reset){ ?>
		<h1>Password Reset</h1>
		<p>Reset successful. Redirecting...</p>
		<meta http-equiv="refresh" content="3; url=/" />
	<? }elseif($confirmed){ ?>
		<h1>Reset Password</h1>
		<p>Hi, <strong><?php echo $email ?></strong>. Please enter your new password below.</p>
		<form method="post">
			<input name="password" value="<?= set_value('email') ?>" placeholder="Password"/>
			<br/>
			<input name="confirm_password" type="password" placeholder="Confirm Password"/>
			<br/>
			<input type="submit" value="Reset Password"/>
		</form>
	<? }else{ ?>
		<h1>Invalid Link</h1>
		<p>This link is no longer valid. Please make sure your link is correct and try again. Please wait a moment while you are being redirected, or <?php echo anchor('/','click here') ?>.</p>
		<meta http-equiv="refresh" content="5; url=/" />
	<? } ?>
</div>