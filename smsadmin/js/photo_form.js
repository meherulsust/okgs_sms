$(document).ready(function(){
	 //for father ajax create.
	$("#frm-img").validate({ 
		 submitHandler: function(form) {
			  				$("#mtab").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	 
	 $("#photo_image").rules("add", {
		 required: true,
		 messages: {
		   required: "Image file is required",
		 }
		});
	
	
	  	$('#frm-img #btn-cancel').click(function(){
		    stab.tabs('select',0);
	});
	
	$("#photo-list .action a.edit_actn").click(function(event)
  {
      var index = stab.tabs("option",'selected');
      stab.tabs( "url", index, $(this).attr('href'));
      stab.tabs('load',index);
      event.preventDefault();
  });
  
  
  $('.del_actn').click(function(event){
   	var ret = confirm("Are you sure? \nYou want to delete this photo!");
   	if(ret)
     {
       $.post($(this).attr('href'),
       function(responseText)
       {
           var index = stab.tabs("option",'selected');
           stab.tabs( "url", index, responseText.redirect);
           stab.tabs('load',index);
       },
       'json'
       );
     } 
      
    event.preventDefault();
  });
  
	
 });
 
 
 function saveSuccess(responseText, statusText, xhr, $form) { 
		$("#mtab").unmask();
		if(responseText.success)
		{	
		  var index = stab.tabs("option",'selected');
			stab.tabs( "url", index,responseText.redirect);
			stab.tabs('load',index);
			$('#std-img').attr('src',responseText.photo);
		}	
		else
		{
			$('#Picture #ajax-flash').show().addClass('error').html(responseText.message);
		}
 }
