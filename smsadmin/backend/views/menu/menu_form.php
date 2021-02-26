<form name='frm-menu' id='frm-menu' method='post' action='<?php echo site_url($active_module.'/save/'.$parent_id)?>' >
<fieldset id="personal"><legend>MENU ITEM INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->menuform->render(); ?>
</table>
</fieldset>
<?php echo $this->menuform->render_hidden(); ?>
</form>