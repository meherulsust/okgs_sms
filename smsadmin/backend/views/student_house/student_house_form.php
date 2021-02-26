<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm_student_house').elements.length; i++) {
			document.getElementById('frm_student_house').elements[i].checked = checked;
		}
    }
</script>
<form name='frm_student_house' id='frm_student_house' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="student_house"><legend>STUDENT HOUSE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->studenthouseform->render(); ?>
</table>
</fieldset>
<?php echo $this->studenthouseform->render_hidden(); ?>
</form>