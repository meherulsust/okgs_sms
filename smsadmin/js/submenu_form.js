
$(document).ready(function(){
    $("#frm-menu").validate({ 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#menu_title").rules("add", {
        required: true,
        messages: {
            required: "Title is required"
        }
    }); 
    $("#menu_alias").rules("add", {
        required: true,
        messages: {
            required: "Alias is required"
        }
    });
    $("#menu_url").rules("add", {
        required: true,
        messages: {
            required: "URL is required"
        }
    });
    $("#menu_tips").rules("add", {
        required: true,
        messages: {
            required: "Tips is required"
        }
    });   
    $("#menu_serial").rules("add", {
        required: true,
        number:true,
        messages: {
            required: "Sequence is required",
            number: "Sequence must be a number"
        }
    }); 
    
    $('#frm-menu #btn-cancel').click(function(){
        $(dialog).dialog('close');
    });
         
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
