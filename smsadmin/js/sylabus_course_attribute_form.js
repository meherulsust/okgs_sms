$(document).ready(function(){
	$("#frm-sylabus-course-attribute").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	$("#sylabus_attribute_course_attribute_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Sylabus attribute is required"
		 }
		});
		
	$('#frm-sylabus-course-attribute #btn-cancel').click(function(){
	  $(dialog).dialog('close');
	});
 });
 
 function saveSuccess(responseText, statusText, xhr, $form) { 
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
			$('#Attribute #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
