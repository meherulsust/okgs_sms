
<form name='frm-book' id='frm-book' method='post' action='<?php echo site_url($active_module).'/genarate_progress_report'?>' >
	<fieldset id="personal"><legend>Progress Report</legend>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->gprf->render(); ?>
		</table>
	</fieldset>
</form>
<script language='javascript'>
    $(document).ready(function(){
		$('#progress_report_class_id').selectChain({
			target: $('#progress_report_section_id'),
			value:'title',
			url: SITE_URL+'/json/admission_section',
			type: 'post',
			data:{'admission_class_id': 'progress_report_class_id' }
		}); 
		$('#progress_report_class_id').selectChain({
			target: $('#progress_report_exam_id'),
			value:'title',
			url: SITE_URL+'/json/exam',
			type: 'post',
			data:{'admission_class_id': 'progress_report_class_id' }
		});	
	});
	
</script>