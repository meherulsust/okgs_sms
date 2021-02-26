<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-teacher" name='<?php echo $this->bsform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>BALANCE SHEET INFORMATION</legend>
	<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
		<?php echo $this->bsform->render(); ?>
	</table>
</fieldset>
<?php echo $this->bsform->render_hidden(); ?>
</form>
<script>
$(document).ready(function(){
	 //for father ajax create.
	$("#bsheetform_date" ).datepicker({
		changeMonth: false,
		changeYear: false,
		//yearRange: "-50:-05",
		dateFormat: 'yy-mm-dd'
		
	});
});
</script>