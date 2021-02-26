<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm-extra-facility').elements.length; i++) {
			document.getElementById('frm-extra-facility').elements[i].checked = checked;
		}
    }
</script>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-extra-facility" name='frm-extra-facility' method='POST' action='<?php echo site_url($active_module.'/update_extra_facility'); ?>' >
<fieldset id="personal"><legend>STUDENT INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->eform->render(); ?>
</table>
</fieldset>	
<?php echo $this->eform->render_hidden(); ?>
</form>