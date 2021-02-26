$(document).ready(function(){
	
	$('#extra_facility_class_id').selectChain({
	    target: $('#extra_facility_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'extra_facility_class_id'}
	});
	
	$('#extra_facility_class_id').change(function(){		
		var class_id = $('#extra_facility_class_id').val();
		var facility_id = $("input[type='checkbox']").val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student/get_student_facility_list",
			data: "class_id="+class_id+"&section_id="+"&facility_id="+facility_id,
			success: function(response){  					
				$("#extra_facility_student_list_content").html(response);	
			}
		});		
	});
	
	$('#extra_facility_section_id').change(function(){		
		var class_id = $('#extra_facility_class_id').val();
		var section_id = $('#extra_facility_section_id').val();
		var facility_id = $('#extra_facility_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student/get_student_facility_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#extra_facility_student_list_content").html(response);	
			}
		});		
	});
	
	$('#extra_facility_facility_id').change(function(){		
		var class_id = $('#extra_facility_class_id').val();
		var section_id = $('#extra_facility_section_id').val();
		var facility_id = $('#extra_facility_facility_id').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student/get_student_facility_list",
			data: "class_id="+class_id+"&section_id="+section_id+"&facility_id="+facility_id,
			success: function(response){  					
				$("#extra_facility_student_list_content").html(response);	
			}
		});		
	});

	
	$("#frm-extra-facility").validate();
	 
		
	$("#extra_facility_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});
	
	$("#extra_facility_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});
	
	$("#extra_facility_facility_id").rules("add", {
		required: true,
		messages: {
			required: "Facility name is required"
		}
	});
	
	$("#student_id").rules("add", {
		required: true,
		messages: {
			required: "Student is required"
		}
	}); 
	
	
	
        
    $('#cancell-btn').click(function(){
        window.location=SITE_URL+'/student/index';
	});  
	
	
});
