<?php $this->tpl->set_js('lookup_form'); ?>
<form name='frm-lookup' id='frm-lookup' method='post' action='<?php echo site_url($active_module.'/lookupsave')?>' >
<fieldset id="personal"><legend>LOOKUP ITEM INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->lform->render(); ?>
</table>
</fieldset>
<?php echo $this->lform->render_hidden(); ?>
</form>