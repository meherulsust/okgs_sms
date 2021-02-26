$(document).ready(function(){
	 //for father ajax create.
	$("#frm-mother-info").validate({ 
		 submitHandler: function(form) {
			  				$("#mtab").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	
	$("#mother_first_name").rules("add", {
		 required: true,
		 minlength: 3,
		 messages: {
		   required: "First Name is required",
		   minlength: jQuery.format("Please, at least {0} characters are necessary")
		 }
		});
	
	  	$('#frm-mother-info #btn-cancel').click(function(){
	//	var index = stab.tabs("option",'selected');
		//stab.tabs( "url", index, $('#personal_cancel_url').val());
		//alert(index);
		stab.tabs('select',0);
		//event.preventDefault();
	});
	
 });

 function saveSuccess(responseText, statusText, xhr, $form) { 
		$("#mtab").unmask();
		if(responseText.success)
		{	
			//$('#std-mother #ajax-flash').show().addClass('error').text(responseText.message);
			var index = stab.tabs("option",'selected');
		  stab.tabs( "url", index,responseText.redirect);
			stab.tabs('load',index);
		
		}	
		else
		{
			$('#std-mother #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
