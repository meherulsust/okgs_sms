<?php 
	$this->tpl->set_jquery_ui(array('datepicker'));
?>
<script>
$(document).ready(function(){       
	$("#payment_status_payment_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#payment_status_start_date',
	    dateFormat: 'yy-mm-dd'
	});	 
 });
</script>
<div id="box">
	<h3 id="adduser">Edit Payment Status</h3>
	<div id='std-create'>
		<?php $this->tpl->load_element('flash_message'); ?>
		<form id="frm-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/edit_payment_status/'.$id); ?>'>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->editpaymentstatusform->render(); ?>
		</table>	
		<?php echo $this->editpaymentstatusform->render_hidden(); ?>
		</form>
	</div>
</div>

