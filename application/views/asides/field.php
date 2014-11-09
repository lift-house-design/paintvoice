<div class="field">
    <?php echo form_label($label,'field-'.$name) ?>
    <div class="input">
    <?php
    	switch($type)
    	{
    		case 'textarea':
    			echo form_textarea(array(
		            'name'=>$name,
		            'id'=>'field-'.$name,
		            'class'=>isset($class) ? $class : NULL,
		            'placeholder'=>isset($placeholder) ? $placeholder : NULL,
		        ));
    			break;
    		case 'text':
    		default:
    			echo form_input(array(
    				'type'=>$type,
		            'name'=>$name,
		            'id'=>'field-'.$name,
		            'class'=>isset($class) ? $class : NULL,
		            'placeholder'=>isset($placeholder) ? $placeholder : NULL,
		        ));
		        break;
    	}
    ?>
    </div>
</div>