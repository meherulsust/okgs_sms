<?php $this->tpl->set_js('user_group_form');?>
<form name='frm-user-group' id='frm-user-group' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="user"><legend>USER GROUP INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->usergroupform->render(); ?>
</table>
</fieldset>
<?php echo $this->usergroupform->render_hidden(); ?>
</form>