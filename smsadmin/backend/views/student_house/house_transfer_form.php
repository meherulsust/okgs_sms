<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm_house_transfer').elements.length; i++) {
			document.getElementById('frm_house_transfer').elements[i].checked = checked;
		}
    }
</script>
<form name='frm_house_transfer' id='frm_house_transfer' method='post' action='<?php echo site_url($active_module.'/update_student_house')?>' >
<fieldset id="house_transfer"><legend>STUDENT HOUSE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->housetransferform->render(); ?>
</table>
</fieldset>
<?php echo $this->housetransferform->render_hidden(); ?>
</form>