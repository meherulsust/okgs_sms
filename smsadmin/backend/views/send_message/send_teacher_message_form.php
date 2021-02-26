<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm_send_message').elements.length; i++) {
			document.getElementById('frm_send_message').elements[i].checked = checked;
		}
    }
</script>
<form name='frm_send_message' id='frm_send_message' method='post' action='<?php echo site_url($active_module.'/teacher_save_send_message')?>' >
<fieldset id="message"><legend>SEND MESSAGE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sendteachermessageform->render(); ?>
</table>
</fieldset>
<?php echo $this->sendteachermessageform->render_hidden(); ?>
</form>