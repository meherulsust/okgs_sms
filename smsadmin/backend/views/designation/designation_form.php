<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-teacher" name='<?php echo $this->dform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>DESIGNATION INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->dform->render(); ?>
</table>
</fieldset>
	<?php echo $this->dform->render_hidden(); ?>
</form>