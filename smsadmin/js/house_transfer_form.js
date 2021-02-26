$(document).ready(function(){
	
	$('#house_transfer_class_id').selectChain({
	    target: $('#house_transfer_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'house_transfer_class_id'}
	});
	
	$('#house_transfer_house_id').change(function(){		
		var class_id = $('#house_transfer_class_id').val();
		var section_id = $('#house_transfer_section_id').val();
		var house_id = $(this).attr('value');
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student_house/get_student_list",
			data: "house_id="+house_id+"&class_id="+class_id+"&section_id="+section_id,
			success: function(response){  					
				$("#house_transfer_student_list_content").html(response);	
			}
		});		
	});

	
	$("#frm_house_transfer").validate();
	 
	$("#house_transfer_house_id").rules("add", {
		required: true,
		messages: {
			required: "House is required"
		}
	}); 
	
	$("#house_transfer_transfer_house_id").rules("add", {
		required: true,
		messages: {
			required: "Transfer house is required"
		}
	});
	
	$("#house_transfer_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});
	
	$("#house_transfer_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});
	
	$("#student_id").rules("add", {
		required: true,
		messages: {
			required: "Student is required"
		}
	}); 
	
	
	
        
    $('#cancell-btn').click(function(){
        window.location=SITE_URL+'/student_house/index';
	});  
	
	
});
