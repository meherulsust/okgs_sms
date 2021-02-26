<form name='frm-tf-form' id='frm-book' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>TUITION FEE HEAD INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->tuitionfeeheadform->render(); ?>
</table>
</fieldset>
<?php echo $this->tuitionfeeheadform->render_hidden(); ?>
</form>