<script language='JavaScript'>
    checked = false;
    function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
		for (var i = 0; i < document.getElementById('frm-promotion').elements.length; i++) {
			document.getElementById('frm-promotion').elements[i].checked = checked;
		}
    }
</script>
<?php $this->tpl->load_element('flash_message');?>
<form id="frm-promotion" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/student_promotion_sectionwise'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->stdpsform->render(); ?>
</table>	
</form>

