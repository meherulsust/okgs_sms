$(document).ready(function(){
    $("#frm-section").validate({ 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
         
  
     
    $("#section_version_id").rules("add", {
        required: true,
        messages: {
            required: "Version/Medium is required"
        }
    });
	
	$("#section_title").rules("add", {
        required: true,
        messages: {
            required: "Form name is required"
        }
    });
	
    $("#section_room_number").rules("add", {
        required: true,
        remote: {
            url: SITE_URL+'/json/chksecroom',
            type: 'post',
            data:{
                class_id: function() {
                    return $("#section_class_id").val()
                },
                id: function() {
                    return $("#section_id").val()
                }
            }
        },
    messages: {
        required: "Room no required",
        remote: "Room is being used"
    }
    });
		
    
	
	
$('#frm-section #btn-cancel').click(function(){
    $(dialog).dialog('close');
});
  

    
    
function saveSuccess(responseText, statusText, xhr, form) { 
    $(".ui-dialog-content").unmask();
    if(responseText.success)
    {	
        $(dialog).dialog('close');
        location.href = responseText.redirect;
    }	
    else
    {
        flashMessage.error(responseText.message);
    }
}

});
