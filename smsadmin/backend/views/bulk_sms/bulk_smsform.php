<?php $this->tpl->set_js('bulk_smsform');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-bulk_sms" name='<?php echo $this->bsform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>BULK SMS INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->bsform->render(); ?>
</table>
</fieldset>
	<?php echo $this->bsform->render_hidden(); ?>
	<input type='hidden' id='datepicker' />
</form>