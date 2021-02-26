<?php $this->tpl->load_element('flash_message');?>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>
<script language='javascript' type='text/javascript'>
var dialog;
$(document).ready(function(){
	   $('#new_admision, #Admission .book_actn,#Admission .edit_actn, #Admission .view_actn').click(function(evnt){
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
		        title: 'Student admission'
		    });
                  $(".ui-dialog-content").mask("Saving...");
		  evnt.preventDefault();
	   });		


	   $('#Admission .del_actn').unbind('click').click(function(event){
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
					   $('#Admission #ajax-flash').show().addClass('error').text(responseText.message);
				  }
			   });
		   } 
		   event.preventDefault();
	  });	
          
          $('a.idcard_actn').attr('target','_blank');
          
  });
</script>
