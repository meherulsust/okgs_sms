<?php $this->tpl->set_js(array('jquery.validate','result_scale_matrix_form'));?>
<form name='frm-scale-matrix' id='frm-scale-matrix' method='post' action='<?php echo site_url($active_module.'/smsave')?>' >
<fieldset id="personal"><legend>RESULT SCALE RANGE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sform->render(); ?>
</table>
</fieldset>
<?php echo $this->sform->render_hidden(); ?>
</form>