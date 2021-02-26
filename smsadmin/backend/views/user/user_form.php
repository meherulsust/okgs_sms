<?php $this->tpl->set_js('user_form');?>
<form name='frm-user' id='frm-user' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="user"><legend>USER INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->userform->render(); ?>
</table>
</fieldset>
<?php echo $this->userform->render_hidden(); ?>
</form>