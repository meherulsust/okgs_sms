<?php $this->tpl->set_js(array('class_tuitionfee_form','jquery.validate')); ?>
<form name='frm-ctf' id='frm-ctf' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>CLASS TUITION FEE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctform->render(); ?>
</table>
</fieldset>
<?php echo $this->ctform->render_hidden(); ?>
</form>