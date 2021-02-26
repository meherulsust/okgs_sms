$(document).ready(function(){
	$('#promotion_class_id').change(function(){
		var class_id = $(this).attr('value');
		var section_id = '';
		$.ajax({
			type: "POST",
			url : SITE_URL+"/student/get_student_list",
			data: "class_id="+class_id+"&section_id="+section_id,
			success: function(response){  					
				$("#promotion_student_list_content").html(response);	
			}
		});		
	});
	
		 
	$("#frm-promotion").validate(); 
	
    $("#promotion_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});  
	
	$("#promotion_promoted_class_id").rules("add", {
		required: true,
		messages: {
			required: "Class name is required"
		}
	});	
  
 });
