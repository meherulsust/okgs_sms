<form name='frm-book' id='frm-book' method='post' action='<?php echo site_url($active_module)?>' >
	<fieldset id="personal"><legend>ADMIT CARD INFORMATION</legend>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->adcform->render(); ?>
		</table>
	</fieldset>
</form>
<script language='javascript'>
    $(document).ready(function(){
		$('#admitcard_class_id').selectChain({
			target: $('#admitcard_section_id'),
			value:'title',
			url: SITE_URL+'/json/admission_section',
			type: 'post',
				data:{'admission_class_id': 'admitcard_class_id' }
		});  		
	});
</script>