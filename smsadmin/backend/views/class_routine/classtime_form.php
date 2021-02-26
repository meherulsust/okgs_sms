<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-class-time" name='<?php echo $this->ctform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save_class_time') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>CLASS TIME INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctform->render(); ?>
</table>
</fieldset>
	<?php echo $this->ctform->render_hidden(); ?>	
</form>