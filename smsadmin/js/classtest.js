var dialog;
$(document).ready(function(){
$('#new_test, .edit_actn, .view_actn').click(function(evnt){
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
	        height: 420,
	        width: 600,
	        title: 'Monthly Exam Form'
	    });
          $(".ui-dialog-content").mask("Loading...");       
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

  $("a.del_actn").unbind('click').click(function(event){
       var url = $(this).attr('href');
       $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:140,
            width:400,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    location.href = url;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
       event.preventDefault();
     }); 

 });
