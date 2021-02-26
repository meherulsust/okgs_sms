$(document).ready(function(){
	
	$('#routine_class_id').selectChain({
	    target: $('#routine_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'routine_class_id'}
	});
	
	$('#routine_class_id').selectChain({
	    target: $('#routine_class_time_id'),
	    value:'title',
	    url: SITE_URL+'/json/class_time',
	    type: 'post',
		data:{class_id: 'routine_class_id'}
	});
	/*
	$('#routine_subject_id').selectChain({
	    target: $('#routine_teacher_id'),
	    value:'title',
	    url: SITE_URL+'/json/teacher',
	    type: 'post',
		data:{subject_id: 'routine_subject_id'}
	});
	*/	
	$("#frm-routine").validate();
	 
		
	$("#routine_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});
	
	$("#routine_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});
	
	$("#routine_subject_id").rules("add", {
		required: true,
		messages: {
			required: "Subject name is required"
		}
	}); 
	
	$("#routine_class_day_id").rules("add", {
		required: true,
		messages: {
			required: "Class Day is required"
		}
	});
	
	$("#routine_class_time_id").rules("add", {
		required: true,
		messages: {
			required: "Class Time is required"
		}
	});
	
	
});
