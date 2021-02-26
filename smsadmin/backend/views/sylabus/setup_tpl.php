<?php $this->tpl->load_element('flash_message');?>
<div id="rightnow">
<h3 class="reallynow"><span> Assign book to <i><?php echo $title ?></i></span> <a href="<?php echo site_url($active_module.'/bookadd/'.$id)?>" class="add" id='subj_assign' title='Assign new subject to sylabus'>Assign Subject</a> <br>
</h3>
</div>
<table width='800' border='0' cellspacing='0' cellpadding='0' id='profile'>
<tr>
		<th>Sylabus Title:</th>
		<td><?php echo $title ?></td>
		<th>Class:</th>
		<td><?php echo $class ?></td>
</tr>
<tr>		
		<th>Form:</th>
		<td><?php echo $section ?></td>
		<th>Created at:</th>
		<td><?php echo mysql_to_audit($created_at) ?></td>
		
</tr>
</table>
<div class='clr'></div>
<div>
<?php $this->tpl->load_element('grid_board'); ?>
</div>
<script language='javascript' type='text/javascript'>
$(document).ready(function(){
	   $('#subj_assign, .edit_actn').click(function(evnt){
		  var url =  $(this).attr('href');
		  var dialog = $('<div>').dialog({
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
		        title: 'Result scale range matrix from'
		    });

		  evnt.preventDefault();
	   });		
	
  });
</script>