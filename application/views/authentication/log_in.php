<h1>Log In</h1>
<?php echo form_open() ?>
    <?php echo form_field('email','E-mail','text',array(
        'placeholder'=>'E-mail Address',
    )) ?>
    <?php echo form_field('password','Password','password',array(
        'placeholder'=>'Password',
    )) ?>
    <div class="buttons"><?php echo form_submit('login','Log In') ?></div>
<?php echo form_close() ?>
<br />
<a href="/authentication/forgot_password">Forgot Password?</a>