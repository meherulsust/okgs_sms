$(document).ready(function(){
	//for father ajax create.
	 
	$('#send_message_message_id').change(function(){
		var message_id = $(this).attr('value');
		$.ajax({
			type: "POST",
			url : SITE_URL+"/json/get_full_message",
			data: "message_id="+message_id,
			success: function(response){  					
				$("#send_message_full_message").val(response);	
			}
		});		
	});
	
	
	$('#send_message_house_id').change(function(){
		var class_id = $('#send_message_class_id').val();
		var section_id = $('#send_message_section_id').val();
		var house_id = $('#send_message_house_id').val();
		var facility_id = $('#send_message_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/send_message/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&house_id="+house_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#send_message_student_list_content").html(response);	
			}
		});		
	});	
	
	$('#send_message_facility_id').change(function(){
		var class_id = $('#send_message_class_id').val();
		var section_id = $('#send_message_section_id').val();
		var house_id = $('#send_message_house_id').val();
		var facility_id = $('#send_message_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/send_message/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&house_id="+house_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#send_message_student_list_content").html(response);	
			}
		});		
	});
	
	$('#send_message_class_id').change(function(){
		var class_id = $('#send_message_class_id').val();
		var section_id = $('#send_message_section_id').val();
		var house_id = $('#send_message_house_id').val();
		var facility_id = $('#send_message_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/send_message/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&house_id="+house_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#send_message_student_list_content").html(response);	
			}
		});		
	});
	
	$('#send_message_class_id').selectChain({
	    target: $('#send_message_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'send_message_class_id'}
	});
	
	$('#send_message_section_id').change(function(){
		var class_id = $('#send_message_class_id').val();
		var section_id = $('#send_message_section_id').val();
		var house_id = $('#send_message_house_id').val();
		var facility_id = $('#send_message_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/send_message/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&house_id="+house_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#send_message_student_list_content").html(response);	
			}
		});		
	});
	
	$('#send_message_designation').change(function(){
		var designation_id = $('#send_message_designation').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/send_message/get_teacher_list",
			data: "designation_id="+designation_id,
			success: function(response){  					
				$("#send_message_teacher_list_content").html(response);	
			}
		});		
	});
	
	
	
	$("#frm_send_message").validate();
	 
	$("#send_message_message_id").rules("add", {
		required: true,
		messages: {
			required: "Message is required"
		}
	}); 
	
	
        
	$('#cancell-btn').click(function(){
		window.location=SITE_URL+'/send_message/index';
	});  
	
	
});
