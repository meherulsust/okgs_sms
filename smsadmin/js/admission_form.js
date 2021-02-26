$(document).ready(function(){
	$("#frm_admission").validate({
		 submitHandler: function(form) {
                    $(".ui-dialog-content").mask("Saving...");
                    $(form).ajaxSubmit({success: saveSuccess});
	   }
	 });
	$("#admission_class_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Class is required"
		 }
		});
		
		$("#admission_section_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Form is required"
		 }
		});
		$("#admission_class_roll").rules("add", {
		 required: true,
		 digits:  true,
		 remote: { url: SITE_URL+'/json/uniqueroll',type: 'post',
				   data:{
					class_id: function() { return $("#admission_class_id").val() },
					section_id: function() { return $("#admission_section_id").val()},
					session: function() { return $("#admission_session").val()},
                                        id: function() { return $("#admission_id").val()}
					}},
		 messages: {
		   required: "Class roll is required",
		   digits: "Class roll must be a number",
		   remote: "Class roll is not available"
		 }
		});
		
		
		$("#admission_fee").rules("add", {
			 required: true,
			 number:  true,
			 messages: {
			   required: "Admission fee is required",
			   digits: "Admission fee must be a number"
			 }
		});
		
		$("#admission_birth_regino").rules("add", {
			required: true,
			messages: {
			   required: "Birth registration field is required"
			 }
		});
		
	 $('#admission_class_id').selectChain({
	    target: $('#admission_section_id'),
	    value:'title',
            afterSuccess:function(){
                if($('#admission_section_id option').length > 1){
                     $('#admission_section_id').siblings('.req').remove();
                     $('#admission_section_id').after('<span class="req">*</span>');
                     $("#admission_section_id").rules("add", {
                    required:true,
                    messages: {
                        required: "Form is required"
                    }
                    });
                }else{
                     $("#admission_section_id").removeClass("error");
                     $("#admission_section_id").next('label.error').remove();
                     $('#admission_section_id').siblings('.req').remove();
                     $("#admission_section_id").rules("remove","required");
                }
            },
	    url: SITE_URL+'/json/admission_section',
	    type: 'post',
            data:$(this).val()
	});
	$('#admission_section_id').selectChain({
		    target: $('#admission_sylabus_id'),
		    value:'title',
		    url: SITE_URL+'/json/sylabus',
		    type: 'post',
		    data:{class_id:'admission_class_id', section_id:'admission_section_id'}
		});	
	 
	$('#frm_admission #cancel-btn').click(function(){
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
                    flashMessage.container = '.ui-dialog-content';
                    flashMessage.error(responseText.message);
		}
 }
