$(document).ready(function(){
	$("#frm-sylabus-evaluation-type").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
     $("#sylabus_eval_type_serial").rules("add", {
        required: true,
        messages: {
            required: "Display serial is required"
        }
    });
	$("#sylabus_eval_type_evaluation_type_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Evaluation type is required"
		 }
		});
		
	$('#frm-sylabus-evaluation-type #btn-cancel').click(function(){
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
			$('#Evaluation #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
