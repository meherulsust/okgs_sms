$(document).ready(function(){
    $("#frm-student-status").validate({ 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#status_status_id").rules("add", {
        required: true,
        messages: {
            required: "Status is required"
        }
    });
	
    $("#status_lookup_id").rules("add", {
        required: true,
        messages: {
            required: "Status reason is required"
        }
    });
    $('#frm-student-status #btn-cancel').click(function(){
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
        flashMessage.container = '.ui-dialog-content';
        flashMessage.error(responseText.message);
    }
}
