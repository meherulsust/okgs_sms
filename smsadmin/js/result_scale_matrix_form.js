$(document).ready(function(){
	 //for father ajax create.
	$("#frm-scale-matrix").validate();
	
	$("#scale_matrix_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Title is required"
		 }
		});
		
  	$("#scale_matrix_min_range").rules("add", {
		 required: true,
		 number: true,
		 messages: {
		   required: "Mimum range is required",
		   number: 'Invalid number'
		 }
		});
		
		$("#scale_matrix_max_range").rules("add", {
		 required: true,
		 number: true,
		 messages: {
		   required: "Maximum range is required",
		   number: 'Invalid number'
		 }
		});
	
		$("#scale_matrix_weight").rules("add", {
		 required: true,
		 number: true,
		 messages: {
		   required: "Weight is required",
		   number: 'Invalid number'
		 }
		});
	$('#btn-sm-cancel').click(function(){
	      $(dialog).dialog('close');	
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
