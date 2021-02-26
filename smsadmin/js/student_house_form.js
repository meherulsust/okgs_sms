$(document).ready(function(){
	
	$('#student_house_class_id').selectChain({
	    target: $('#student_house_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'student_house_class_id'}
	});
	
	$('#student_house_section_id').change(function(){
		var class_id = $('#student_house_class_id').val();
		var section_id = $(this).attr('value');
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student_house/get_student_list",
			data: "house_id=&class_id="+class_id+"&section_id="+section_id,
			success: function(response){  					
				$("#student_house_student_list_content").html(response);	
			}
		});		
	});

	
	$("#frm_student_house").validate();
	 
	$("#student_house_house_id").rules("add", {
		required: true,
		messages: {
			required: "House is required"
		}
	}); 
	
	$("#student_house_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});
	
	$("#student_house_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});
	
	$("#student_house_student_number").rules("add", {
		required: true,
		messages: {
			required: "Student is required"
		}
	}); 
	
	
	
        
    $('#cancell-btn').click(function(){
        window.location=SITE_URL+'/student_house/index';
	});  
	
	
});
