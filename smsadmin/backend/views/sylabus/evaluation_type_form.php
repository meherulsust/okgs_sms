<?php $this->tpl->set_js('evaluation_type_form');?>
<form name='frm-evaluation-type' id='frm-evaluation-type' method='post' action='<?php echo site_url($active_module.'/saveevaltype')?>' >
<fieldset id="resultscale"><legend>EVALUATION COMPONENT  INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->etform->render(); ?>
</table>
</fieldset>
<?php echo $this->etform->render_hidden(); ?>
</form>