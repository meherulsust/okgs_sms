<?php 
	$this->tpl->set_jquery_ui(array('datepicker'));
?>
<script>
$(document).ready(function(){       
	$("#fee_generate_start_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#fee_generate_start_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});	   
	$("#fee_generate_expire_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#fee_generate_expire_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});
 });
</script>
<div id="box">
	<div id='book-create'>
		<form name='frm-tf-form' id='frm-book' method='post' action='<?php echo site_url($active_module.'/generate')?>' >
			<fieldset id="personal"><legend>GENERATE TUITION FEE</legend>
			<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
				<?php echo $this->tfgform->render(); ?>
			</table>
			</fieldset>
			<?php echo $this->tfgform->render_hidden(); ?>
		</form>
</div>
