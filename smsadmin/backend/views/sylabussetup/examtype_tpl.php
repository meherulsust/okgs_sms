<?php $this->tpl->load_element('flash_message');?>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>

 <div id='dialog-confirm'><div>Are you sure? You want to delete this exam type.</div></div>
<script language='javascript' type='text/javascript'>
var dialog;
$(document).ready(function(){
	   $('#new_exam, #Exam_Type .edit_actn, #Exam_Type .view_actn').click(function(evnt){
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
		        title: 'Sylabus Exam Type Information'
		    });

		  evnt.preventDefault();
	   });		

            $('#Exam_Type .eval_actn').click(function(evnt){
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
		        width: 680,
		        title: 'Sylabus course evaluation setup per exam type'
		    });

		  evnt.preventDefault();
	   });		


	   $('#Exam_Type .del_actn').unbind('click').click(function(event){
           
            var url =  $(this).attr('href');
           $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:140,
            width:400,
            modal: true,
            buttons: {
                Yes: function() {
                     $( this ).dialog( "close" );
                      $("#Exam_Type").mask("Deleting...");
			   $.get(url,function(responseText){
				   $("#Exam_Type").unmask();
				   if(responseText.success)
				   {
					   var index = stab.tabs("option",'selected');  
					   stab.tabs('load',index);
				   }
				   else
				  {
					   $('#Exam_Type #ajax-flash').show().addClass('error').text(responseText.message);
				  }
			   });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
                         
			 
		   
		   event.preventDefault();
	  });		
  });
</script>