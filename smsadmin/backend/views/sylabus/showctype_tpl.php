<div id="rightnow">
<h3 class="reallynow"><span>Course type details</span> <a href="<?php echo site_url($active_module.'/newctype')?>" class="add" title='Create course type'>Add Course Type</a> <br>
</h3>
<table  id='profile'>
<tbody>
<tr>
	<th>Course Type Name:</th><td class='txt'><?php echo $title; ?></td>
	<th>Description:</th><td class='txt'><?php echo $description; ?></td></tr>
<tr>
	<th>Status:</th><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td>
	<th>Created At:</th><td class='txt'><?php echo mysql_to_audit($created_at); ?></td>
</tr>
</tbody>
</table>
</div>
<div class='clr'></div>
<div>
<?php $this->tpl->load_element('flash_message');?>
<?php $this->tpl->load_element('grid_board');?>
</div>
<script language='javascript' type='text/javascript'>
  var dialog;
  $(document).ready(function(){
	   $('#new_course_type_attr, .edit_actn, .view_actn').click(function(evnt){
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
		        title: 'Course type attribute information'
		    });

		  evnt.preventDefault();
	   });
  });
</script>


