var dialog;
$(document).ready(function(){
$('#new_sec, .edit_actn, .view_actn').click(function(evnt){ 
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
	        height: 350,
	        width: 600,
	        title: 'Form Form'
	    });
         $(".ui-dialog-content").mask("Loading...");    
	  evnt.preventDefault();
 });
 
 });
