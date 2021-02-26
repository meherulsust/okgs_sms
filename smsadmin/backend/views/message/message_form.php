<?php $this->tpl->set_js('message_form');?>
<form name='frm-user' id='frm-user' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="message"><legend>MESSAGE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->messageform->render(); ?>
</table>
</fieldset>
<?php echo $this->messageform->render_hidden(); ?>
</form>