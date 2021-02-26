<?php $this->tpl->set_js('result_scale_form');?>
<form name='frm-result-scale' id='frm-result-scale' method='post' action='<?php echo site_url($active_module.'/savescale')?>' >
<fieldset id="resultscale"><legend>RESULT SCALE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->rsform->render(); ?>
</table>
</fieldset>
<?php echo $this->rsform->render_hidden(); ?>
</form>