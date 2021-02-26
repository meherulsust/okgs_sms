$(document).ready(function(){

$('input.sel-all').change(function(){
	var id = $(this).val();
	$('.ctype_'+id).attr('checked',$(this).is(':checked'));
});

	$('.admission-course #cancel-btn').click(function(){
	  $(dialog).dialog('close');
	});
	
	
	$("#assign_course").validate({ 
		 submitHandler: function(form) {
		         if($('input:checked').length == 0)
              {
                $("#alert-message" ).dialog({
                      modal: true,
                      buttons: {
                          Ok: function() {
                              $( this ).dialog( "close" );
                          }
                      }
                  });
                return false;
              }
            else
            {
			  		  $(".ui-dialog-content").mask("Saving...");
						  $(form).ajaxSubmit({success: saveSuccess});
						}  
	 			}
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
			$('.admission-course #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }

