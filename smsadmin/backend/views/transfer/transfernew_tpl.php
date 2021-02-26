<?php $this->tpl->load_element('flash_message'); ?>
<?php $this->tpl->set_js('student_transfer_form') ?>
<form name='frm-student-transfer '  id="frm-student-transfer" method='POST' action='<?php echo site_url($active_module.'/save'); ?>' >
<fieldset id="personal"><legend>STUDENT TRANSFER INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->stform->render(); ?>
</table>
</fieldset>
	<?php echo $this->stform->render_hidden(); ?>
</form>
<div class='dialog-alert'><div>Please specify student number.</div></div>