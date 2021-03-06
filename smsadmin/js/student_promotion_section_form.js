$(document).ready(function(){
	
	$('#promotion_class_id').selectChain({
	    target: $('#promotion_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		  data:{class_id: 'promotion_class_id'}
	});
	
	$('#promotion_promoted_class_id').selectChain({
	    target: $('#promotion_promoted_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		  data:{class_id: 'promotion_promoted_class_id'}
	});
	
	$('#promotion_section_id').change(function(){
		var class_id = $('#promotion_class_id').attr('value');
		var section_id = $(this).attr('value');
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

	$("#promotion_section_id").rules("add", {
		required: true,
		messages: {
			required: "Form name is required"
		}
	});	
	
	$("#promotion_promoted_class_id").rules("add", {
		required: true,
		messages: {
			required: "Promoted Class is required"
		}
	});	
	
	$("#promotion_promoted_section_id").rules("add", {
		required: true,
		messages: {
			required: "Promoted Form is required"
		}
	});	
  
 });
