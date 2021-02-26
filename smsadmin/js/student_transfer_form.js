$(document).ready(function(){
    $("#frm-student-transfer").validate({ 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#transfer_student_number").rules("add", {
        required: true,
        messages: {
            required: "Required"
        }
    });
	
    $("#transfer_reason_id").rules("add", {
        required: true,
        messages: {
            required: "Transfer reason is required"
        }
    });
    $('#frm-student-transfer #cancel-btn').click(function(){
        $(dialog).dialog('close');
    });
    
    $("#std-check").click(function(evnt){
        var std_number = $("#transfer_student_number").val();
        if(std_number =='')
        {
            $('.dialog-alert').dialog({
                modal: true,
                buttons:{
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                } 
            });
            return false;
    }       
    var url =  SITE_URL+'/transfer/stdinfo/'+ std_number;
   
   $('<div id="std-info">').dialog({
        modal: true,
        create: function (event, ui)
        {
            $(this).load(url);
        }, 
        close: function(event, ui) {
            $(this).remove();
        },        
        height: 320,
        width: 500,
        title: 'Student details information',
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
        }    
    });
    $('#std-info.ui-dialog-content').mask('Loading....');
    evnt.preventDefault();
    });
});


 
function saveSuccess(responseText, statusText, xhr, $form) { 
    $(".ui-dialog-content").unmask();
    if(responseText.success)
    {	
        location.href = responseText.redirect;	
    }	
    else
    {
        flashMessage.container = '.ui-dialog-content';
        flashMessage.error(responseText.message);
    }
}



