<?php $this->tpl->load_element('flash_message');?>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>
<script language='javascript' type='text/javascript'>
var dialog;
$(document).ready(function(){
	   $('#status_add, #Status .edit_actn, #Status .view_actn').click(function(evnt){
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
		        title: 'Student status'
		    });

		  evnt.preventDefault();
	   });			
  });
</script>
