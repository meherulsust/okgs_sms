<?php $this->tpl->load_element('flash_message');?>
<div id="rightnow">
<h3 class="reallynow"><span>Defining scale range of result scale<i><?php echo $title ?></i></span> <a href="<?php echo site_url($active_module.'/newscale/')?>" class="add" id='new_scale' title='Create New Scale'>
New Result Scale</a> <br>
</h3>
</div>
<table width='800' border='0' cellspacing='0' cellpadding='0' id='profile'>
<tr>
		<th>Scale Title:</th>
		<td><?php echo $title ?></td>
		<th>Description:</th>
		<td><?php echo $description ?></td>
</tr>
<tr>		
		<th>Status:</th>
		<td><?php echo ucfirst(strtolower($status)) ?></td>
		<th>Created at:</th>
		<td><?php echo mysql_to_audit($created_at) ?></td>
		
</tr>
</table>
<div class='clr'></div>
<div>
<?php 
$this->tpl->load_element('grid_board');
?>
</div>
<script language='javascript' type='text/javascript'>
  var dialog;
  $(document).ready(function(){
	      $('#sradd, .edit_actn').click(function(evnt){
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
		        title: 'Result scale range matrix from'
		    });

		  evnt.preventDefault();
	   });		
	
  });
</script>
