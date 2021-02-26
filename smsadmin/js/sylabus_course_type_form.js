$(document).ready(function(){
	$("#frm-sylabus-course-type").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	$("#sylabus_course_type_course_type_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Course type is required"
		 }
		});
		
	$('#frm-sylabus-course-type #btn-cancel').click(function(){
	  $(dialog).dialog('close');
	});
 });
 
 function saveSuccess(responseText, statusText, xhr, form) { 
		$(".ui-dialog-content").unmask();
		if(responseText.success)
		{	
		   $(dialog).dialog('close');
			 var index = stab.tabs("option",'selected');
		  // stab.tabs( "url", index,responseText.redirect);
			 stab.tabs('load',index);
		
		}	
		else
		{
			$('#Course_Type #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
