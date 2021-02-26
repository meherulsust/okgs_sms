<form name='frm-house' id='frm-house' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="house12"><legend>HOUSE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->houseform->render(); ?>
</table>
</fieldset>
<?php echo $this->houseform->render_hidden(); ?>
</form>