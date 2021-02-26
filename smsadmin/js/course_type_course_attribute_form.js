$(document).ready(function(){
	$("#frm-ctca").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	 /*
	$("#type_atribute_course_attribute_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Course type attribute is required"
		 }
		});
		*/
	$('#frm-ctca #btn-cancel').click(function(){
	  $(dialog).dialog('close');
	});
 });
 
 function saveSuccess(responseText, statusText, xhr, $form) {
		$(".ui-dialog-content").unmask();
		if(responseText.success)
		{	
		   $(dialog).dialog('close');
		   location.href = responseText.redirect;
		}	
		else
		{
			$('#ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
