<?php  $this->tpl->load_element('flash_message'); ?>
<div id="box">
<h3 id="adduser">Change profile information</h3>
<div id='edit-profile'>
<?php  $this->tpl->set_js(array('profile_form')); ?>
<form name='frm-user' id='frm-user' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>PROFILE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->pform->render(); ?>
</table>
</fieldset>
<?php echo $this->pform->render_hidden(); ?>
</form>
</div>
</div>