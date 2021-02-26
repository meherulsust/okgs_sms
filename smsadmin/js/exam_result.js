$(document).ready(function(){
    $('#cancel-btn').click(function(){
        $(dialog).dialog('close');
    });
    $("#save-btn").click(function(){
        $(".ui-dialog-content").mask("Saving...");
        $.post(SITE_URL+"/result/save/"+$("#reg_id").val(),
            function(response)
            {
                $(".ui-dialog-content").unmask();
                if(response.success)
                {
                    flashMessage.success(response.message);
        	
                }
                else
                {
                    flashMessage.error(response.message);
                }
                $(dialog).dialog('close');
            },
            'json'
            );
    });
    $("#update-btn").click(function(){
         
        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:140,
            width:400,
            modal: true,
            buttons: {
                "Proceed": function() {
                    $( this ).dialog( "close" );
                    update_result();
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        return false;
    });
    
    
});

function update_result(){
        $(".ui-dialog-content").mask("Updating...");
        $.post(SITE_URL+"/result/update/"+$("#reg_id").val(),
            function(response)
            {
                $(".ui-dialog-content").unmask();
                if(response.success)
                {
                    flashMessage.success(response.message);
        	
                }
                else
                {
                    flashMessage.error(response.message);
                }
                $(dialog).dialog('close');
            },
            'json'
            );
}
