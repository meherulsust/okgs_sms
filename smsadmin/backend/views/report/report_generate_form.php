<?php $this->tpl->load_element('flash_message');?>
<form id="frm-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/download'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->rgform->render(); ?>
</table>	
</form>

<script language='javascript'>
    $(document).ready(function(){
		$('#report_class_id').selectChain({
			target: $('#report_section_id'),
			value:'title',
			url: SITE_URL+'/json/admission_section',
			type: 'post',
				data:{'admission_class_id': 'report_class_id' }
		});  
		 
		 
				
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
		
		
		//$('#frm-report').validate();
		
		
	});
</script>

