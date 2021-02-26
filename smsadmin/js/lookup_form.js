$(document).ready(function(){
    $("#frm-lookup").validate({ 
		 submitHandler: function(form) {
			  			$(".ui-dialog-content").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
         
    if($('#lookup_value_type').val() == 'TEXT')
         $(dialog).dialog( "option", "height", 430);
     
    $("#lookup_title").rules("add", {
        required: true,
        messages: {
            required: "Lookup name is required"
        }
    });
	
    $("#lookup_unique_code").rules("add", {
        required: true,
        remote: { url: SITE_URL+'/json/lookupcode',type: 'post',
				   data:{
					type_id: function() { return $("#lookup_lookup_type_id").val() },
					id: function() { return $("#lookup_id").val()}
					}},
        messages: {
            required: "Lookup code is required",
            remote: "Lookup code is being used"
        }
    });
		
    $("#lookup_value").rules("add", {
        required: true,
        messages: {
            required: "lookup value required"
        }
    });
	
	
    $('#frm-lookup #cancel-btn').click(function(){
        $(dialog).dialog('close');
    });
  
  
    $('#lookup_value_type').change(function(){
        var td = $('#lookup_value').parent();
        var elem,val ;
        $("#lookup_value").rules("remove","number");
        val = $("#lookup_value").val();
        $('#lookup_value').remove();
        $(dialog).dialog( "option", "height", 350);
        switch($(this).val()){
            case 'TEXT':
                elem = $('<textarea name="lookup_value" id="lookup_value">'+ val + '</textarea>');
                elem.css({
                    width:'200px',
                    height:'100px'
                });
                $(dialog).dialog( "option", "height", 430);
                td.prepend(elem);
                break;
            case 'NUMBER':
                elem = $('<input type="text" name="lookup_value" id="lookup_value" value="'+ val + '" class="txt" />');
                td.prepend(elem);
                $("#lookup_value").rules("add", {
                    number:true,
                    messages: {
                        number: "Value is not a number"
                    }
                });
                break;
                   
            default:
                elem = $('<input type="text" name="lookup_value" id="lookup_value" value="'+ val + '" class="txt" />');
                td.prepend(elem);
        }
    
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
