$(document).ready(function(){
	   
	$('#attendance_class_id').selectChain({
	    target: $('#attendance_section_id'),
	    value:'title',
	    url: SITE_URL+'json/section',
	    type: 'post',
		  data:{class_id: 'attendance_class_id'}
	});
	
	
	$('#attendance_section_id').change(function(){
		var class_id = $('#attendance_class_id').val();
		var section_id = $(this).attr('value');
		$.ajax({
			type: "POST",
			url : SITE_URL+"attendance/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id,
			success: function(response){  					
				$("#attendance_student_list_content").html(response);	
			}
		});		
	});	
        
	$("#attendance_adatepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#attendance_attendance_date',
	    dateFormat: 'yy-mm-dd'
	});
	
	$("#frm-attendance").validate();
	
	$("#attendance_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});
    
	$("#attendance_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});
	
	$("#attendance_adatepicker").rules("add", {
		required: true,
		date: true,
		messages: {
			required: "Date is required",
			date: "Date format is not valid"
		}
	});
	
	$("#attendance_student_id").rules("add", {
		required: true,
		messages: {
			required: "Student is required."
		}
	}); 
		  	  
  
 });
