var dialog;
$(document).ready(function(){
$('#new_regi, .edit_actn, .view_actn').click(function(evnt){ 
	   var url =  $(this).attr('href');
	   dialog = $('<div>').dialog({
	        modal: true,
	        create: function (event, ui)
	        {
	            $(this).load(url);
	        }, 
	        
	        close: function(event, ui) {
             $(this).remove();
         },        
	        height: 400,
	        width: 600,
	        title: 'Student Registration Form'
	    });
	  evnt.preventDefault();
 });	
 
 $('.marks_actn').click(function(evnt){ 
	   var url =  $(this).attr('href');
	   dialog = $('<div>').dialog({
	        modal: true,
	        create: function (event, ui)
	        {
	            $(this).load(url);
	        }, 
	        
	        close: function(event, ui) {
             $(this).remove();
         },        
	        height: 550,
	        width: 600,
	        title: 'Student exam marks'
	    });
	  evnt.preventDefault();
 });	
 
 $('.result_actn').click(function(evnt){ 
	   var url =  $(this).attr('href');
	   dialog = $('<div>').dialog({
	        modal: true,
	        create: function (event, ui)
	        {
	            $(this).load(url);
	        }, 
	        
	        close: function(event, ui) {
             $(this).remove();
         },        
	        height: 500,
	        width: 900,
	        title: 'Student exam result'
	    });
	  evnt.preventDefault();
 });	
 
$('#register').click(function(event){
     $("#content").mask("Saving...");
     $.post($(this).attr('href'),
       function(response)
       {
         $("#content").unmask();
         if(response.success)
         {
        	 location.href = response.redirect;
         }
         else
         {
        	 $('#ajax-flash').show().addClass('error').text(response.message);
         }	 
       },
       'json'
       );
  
	  event.preventDefault();

});

 });
