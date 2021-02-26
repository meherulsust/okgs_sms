<form name='frm_send_notice' id='frm_send_notice' method='post' action='<?php echo site_url($active_module.'/save_notice')?>' >
<fieldset id="message"><legend>NOTICE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->noticeboardform->render(); ?>
</table>
</fieldset>
<?php echo $this->noticeboardform->render_hidden(); ?>
</form>