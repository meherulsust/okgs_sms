<?php 
	$this->tpl->set_jquery_ui(array('datepicker'));
	$this->tpl->set_js(array('attendance_form','jquery.validate','select-chain'));
?>
<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm-attendance').elements.length; i++) {
			document.getElementById('frm-attendance').elements[i].checked = checked;
		}
    }
</script>
<form name='frm-attendance' id='frm-attendance' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>ATTENDENCE RECORD FORM</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->attendanceform->render(); ?>
</table>
</fieldset>
<?php echo $this->attendanceform->render_hidden(); ?>
</form>