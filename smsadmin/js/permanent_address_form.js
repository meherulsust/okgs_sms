$(document).ready(function(){
	 //for father ajax create.
	$("#frm-permanent-address").validate({ 
		 submitHandler: function(form) {
			  				$("#mtab").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	$("#permanent_address_line").rules("add", {
		 required: true,
		 messages: {
		   required: "Address is required",
		 }
		});
	$('#frm-permanent-address #btn-cancel').click(function(){
	//	var index = stab.tabs("option",'selected');
		//stab.tabs( "url", index, $('#personal_cancel_url').val());
		//alert(index);
		stab.tabs('select',0);
		//event.preventDefault();
	});
	$('#permanent_district').selectChain({
	    target: $('#permanent_thana'),
	    value:'title',
	    url: SITE_URL+'/json/thana',
	    type: 'post',
		data:$(this).val()
	});
	$('#permanent_thana').selectChain({
	    target: $('#permanent_post_office_id'),
	    value:'title',
	    url: SITE_URL+'/json/poffice',
	    type: 'post',
		data:$(this).val()
	});
	
	
 });

 function saveSuccess(responseText, statusText, xhr, $form) { 
		$("#mtab").unmask();
		if(responseText.success)
		{	
			 var index = stab.tabs("option",'selected');
		   stab.tabs( "url", index,responseText.redirect);
			 stab.tabs('load',index);
		}	
		else
		{
			$('#std-permanent-address #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
