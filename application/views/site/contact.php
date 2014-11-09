<div class="grid-50">
    <div class="content"><?php echo $content ?></div>
    <?php echo form_open() ?>
        <input id="form-check" type="hidden" name="00<?= sha1(rand(0,time())) ?>" value=""/>
        <?php echo form_field('name','Name','text',array(
            'placeholder'=>'Name (first and last)',
        )) ?>
        <?php echo form_field('phone','Phone','text',array(
            'placeholder'=>'Phone Number',
        )) ?>
        <?php echo form_field('email','E-mail','text',array(
            'placeholder'=>'E-mail Address',
        )) ?>
        <?php echo form_field('message','Message','textarea',array(
            'placeholder'=>'What can we build for you?',
        )) ?>
        <!--div class="buttons"><?php echo form_submit('submit','Send','class="large"') ?></div-->
        <?php echo form_submit('submit','Send','class="large"') ?>
    <?php echo form_close() ?>
</div>
<div class="grid-50">
    <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d14239.123551358973!2d-80.12959035707841!3d26.846920595762334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sCouture+Homes+Phone%3A+561.776.0511+3900+Military+Trail+Jupiter%2C+FL+33458!5e0!3m2!1sen!2s!4v1412264711813"></iframe>
    <div class="address">
        Couture Homes<br />
        Phone: 561.776.0511<br />
        3900 Military Trail<br />
        Jupiter, FL 33458
    </div>
</div>