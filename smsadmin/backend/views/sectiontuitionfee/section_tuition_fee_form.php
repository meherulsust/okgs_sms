<?php $this->tpl->set_js(array('section_tuitionfee_form','jquery.validate','select-chain')); ?>
<form name='frm-stf' id='frm-stf' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>FORM TUITION FEE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->stform->render(); ?>
</table>
</fieldset>
<?php echo $this->stform->render_hidden(); ?>
</form>