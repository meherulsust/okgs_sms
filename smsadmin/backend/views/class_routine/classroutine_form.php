<?php $this->tpl->set_js('classroutine_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-routine" name='<?php echo $this->crform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>ROUTINE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->crform->render(); ?>
</table>
</fieldset>
	<?php echo $this->crform->render_hidden(); ?>	
</form>