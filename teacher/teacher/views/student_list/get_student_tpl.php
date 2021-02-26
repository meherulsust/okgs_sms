
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="5%" align="center"><b>#</b></th>
		<th width="20%" align="center"><b>Name</b></th>
		<th width="20%" align="center"><b>Student Number</b></th>
		<th width="20%" align="center"><b>Mobile Number</b></th>
		<th width="10%" align="center"><b>Class Roll</b></th>
		<th width="10%" align="center"><b>Gender</b></th>
		<th width="5%" align="center"><b>Action </b></th>	
	</tr>
	<?php if($student_list): ?>
	<?php 
	$i=1;
	foreach($student_list as $list):
	?>
	
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $list->first_name.' '.$list->last_name ;?></td>	
		<td><?php echo $list->student_number; ?></td>
		<td><?php echo $list->mobile; ?></td>
		<td><?php echo $list->class_roll; ?></td>
		<td><?php echo $list->gender;?></td>		
		<td align="center">
			<a href="<?php echo site_url('student_list/student_profile/'.$list->id); ?>" title="View Student Detail" target="_blank">
			<img src="<?php echo base_url();?>images/actn_view.png"/></a>
		</td>	
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='5'>No Student List found.</td>		
	</tr>
        <?php endif ?>
</table>



<body>
    <div id="pdfContainer" class = "pdf-content">
    </div>
</body>


<script>
	$(document).ready(function(){  
		$('#class_id').selectChain({
			target: $('#section_id'),
			value:'title',
			url: '<?php echo site_url();?>/home/section',
			type: 'post',
			data:{'class_id': 'class_id' }
		});  
		
		$('#section_id').change(function(){
			var class_id = $('#class_id').val();
			var section_id = $(this).val();
			$.ajax({
				type: "POST",
				url : '<?php echo site_url();?>/student_list/get_student',
				data: "class_id="+class_id+"&section_id="+section_id,
				success: function(response){  					
					$("#notebook").html(response);
				}
			});		
		});
    });
</script>
