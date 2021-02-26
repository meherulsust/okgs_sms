<?php $this->tpl->set_js('unpaid_sms');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-bulk_sms" name='<?php echo $this->upmform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>UNPAID SMS INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->upmform->render(); ?>
</table>
</fieldset>
	<?php echo $this->upmform->render_hidden(); ?>
	<input type='hidden' id='datepicker' />
</form>