$(document).ready(function(){
	$("#frm-sylabus-exam-type").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	$("#sylabus_exam_type_exam_type_lookup_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Exam type is required"
		 }
		});
	
       $("#sylabus_exam_type_final_percent").rules("add", {
		 required: true,
                 number : true,
		 messages: {
		   required: "Final percent is required",
                   number : 'Must be a number'
		 }
		});
			
	$('#frm-sylabus-exam-type #btn-cancel').click(function(){
	  $(dialog).dialog('close');
	});
 });
 
 function saveSuccess(responseText, statusText, xhr, $form) { 
		$(".ui-dialog-content").unmask();
		if(responseText.success)
		{	
		   $(dialog).dialog('close');
			 var index = stab.tabs("option",'selected');
			 stab.tabs('load',index);
		
		}	
		else
		{
			$('#Evaluation #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
