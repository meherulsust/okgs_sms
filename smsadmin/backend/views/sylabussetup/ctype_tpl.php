<?php $this->tpl->load_element('flash_message');?>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>
<script language='javascript' type='text/javascript'>
var dialog;
$(document).ready(function(){
	   $('#assign_new_type, #Course_Type .edit_actn, #Course_Type .view_actn').click(function(evnt){
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
		        height: 250,
		        width: 600,
		        title: 'Sylabus Course Type'
		    });

		  evnt.preventDefault();
	   });		


	   $('#Course_Type .del_actn').unbind('click').click(function(event){
		   if(confirm("Are you sure? You want to delete this record!"))
		   {
			   var url =  $(this).attr('href');
			   $("#Course_Type").mask("Deleting...");
			   $.get(url,function(responseText){
				   $("#Course_Type").unmask();
				   if(responseText.success)
				   {
					   var index = stab.tabs("option",'selected');  
					   stab.tabs('load',index);
				   }
				   else
				  {
					   $('#Course_Type #ajax-flash').show().addClass('error').text(responseText.message);
				  }
			   });
		   } 
		   event.preventDefault();
	  });		
  });
</script>