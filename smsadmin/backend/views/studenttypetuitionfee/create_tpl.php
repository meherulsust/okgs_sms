<script>
$(document).ready(function(){
	$('#sttf_class_id').selectChain({
	    target: $('#sttf_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'sttf_class_id'}
	});	
});
</script>
<div id="box">
<h3 id="stconfig">Configure Student Type wise Tuition Fee</h3>
<div id='st-create'>
<?php $this->load->view('studenttypetuitionfee/student_type_tuition_fee_form') ?>
</div>
</div>