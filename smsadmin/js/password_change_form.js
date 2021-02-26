$(document).ready(function(){
    $("#frm-chpass").validate(
    { 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    
    $("#old_password").rules("add", {
        required: true,
        remote:{url: SITE_URL+'/json/chkpass',type: 'post'},
        messages: {
            required: "Old password is required",
            remote:  "Old password is not correct"
        }
    });

    $("#password").rules("add", {
        required: true,
        messages: {
            required: "Password is required"
        }
    });
    
    $("#re_password").rules("add", {
        required: true,
        equalTo: "#password",
        messages: {
            required: "Password is required",
            equalTo: "Two passwords are not equal"
        }
    });
    $('#frm-chpass #btn-cancel').click(function(){
        $(dialog).dialog('close');
    });
    
  
});
 
function saveSuccess(responseText, statusText, xhr, $form) { 
    $(".ui-dialog-content").unmask();
    if(responseText.success)
    {	
       // flashMessage.container = '.ui-dialog-content';
        flashMessage.success(responseText.message);
        $(dialog).dialog('close');
    }	
    else
    {
        flashMessage.container = '.ui-dialog-content';
        flashMessage.error(responseText.message);
    }
}



