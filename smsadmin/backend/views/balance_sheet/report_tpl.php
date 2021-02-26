<?php $this->tpl->load_element('flash_message');?>
<form name="monthly-report" id="monthly-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/report_download'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->bform->render(); ?>
</table>	
</form>
<script>
$(document).ready(function(){
	 //for father ajax create.
	$("#report_day_from" ).datepicker({
		changeMonth: false,
		changeYear: false,
		//yearRange: "-50:-05",
		dateFormat: 'yy-mm-dd'
		
	});	
	
	$("#report_day_to" ).datepicker({
		changeMonth: false,
		changeYear: false,
		//yearRange: "-50:-05",
		dateFormat: 'yy-mm-dd'
		
	});
	
	$("#monthly-report").validate();
	 
	 $("#report_year").rules("add", {
		 required: true,
		 messages: {
		   required: "Year is required."
		 }
		});
		
        /*   $("#report_month").rules("add", {
		 required: true,
		 messages: {
		   required: "Month is required."
		 }
		});	 */	       
	 
  
 });
</script>
