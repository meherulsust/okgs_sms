<?php $this->tpl->set_js('stuff_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-stuff" name='<?php echo $this->sform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>STAFF INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sform->render(); ?>
</table>
</fieldset>
	<?php echo $this->sform->render_hidden(); ?>
	<input type='hidden' id='datepicker' />
</form>