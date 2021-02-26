<?php $this->tpl->set_js(array('student_type_tuitionfee_form','jquery.validate')); ?>
<form name='frm-stf' id='frm-stf' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>STUDENT TYPE TUITION FEE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sttform->render(); ?>
</table>
</fieldset>
<?php echo $this->sttform->render_hidden(); ?>
</form>