<?php $this->tpl->load_element('flash_message');?>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>
<script language='javascript' type='text/javascript'>
var dialog;
$(document).ready(function(){
	   $('#new_attribute, #Attribute .edit_actn, #Attribute .view_actn').click(function(evnt){
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
		        height: 300,
		        width: 600,
		        title: 'Sylabus Attribute Information'
		    });

		  evnt.preventDefault();
	   });		


	   $('#Attribute .del_actn').unbind('click').click(function(event){
		   if(confirm("Are you sure? You want to delete this record!"))
		   {
			   var url =  $(this).attr('href');
			   $("#Attribute").mask("Deleting...");
			   $.get(url,function(responseText){
				   $("#Attribute").unmask();
				   if(responseText.success)
				   {
					   var index = stab.tabs("option",'selected');  
					   stab.tabs('load',index);
				   }
				   else
				  {
					   $('#Attribute #ajax-flash').show().addClass('error').text(responseText.message);
				  }
			   });
		   } 
		   event.preventDefault();
	  });		
  });
</script>
