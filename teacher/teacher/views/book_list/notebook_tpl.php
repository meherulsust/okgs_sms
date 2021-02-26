<h1>Note List</h1>
<form action="#" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Class </b></td>
		<td>
		<b><?php //echo $class; ?>
		
			<select class="textfield" id="class_id" name="class_id">
			<option value="">---Select Class--</option>
			  <?php foreach($get_class as $val){?>
			  <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
			  <?php }?>
			</select>		
		</b>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Form </b> </td>
		<td>
			<select class="textfield" id="section_id" name="section_id">
				<option value="">---Select Section--</option>				  
			</select>	
		</td>			
	</tr>
</table>
</form>
<div id="notebook">
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL. No.</b></th>
		<th width="30%" align="center"><b>Note Name</b></th>
		<th width="30%" align="center"><b>Description </b></th>
		<th width="20%" align="center"><b>Subject</b></th>
		<th width="10%" align="center"><b>Action </b></th>	
	</tr>
	<?php if($notebook_list): ?>
	<?php 
	$i=1;
	foreach($notebook_list as $note):
	?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $note['title']; ?></td>	
		<td><?php echo $note['description']; ?></td>
		<td><?php echo $note['subject']; ?></td>	
		<td align="center">
			<a href="<?php echo site_url('book_list/note_download/'.$note['file_name']); ?>" title="Download">
				<img src="<?php echo base_url();?>images/download.png"/>
			</a>
			<a href="<?php echo site_url('book_list/note_view/'.$note['file_name']); ?>" target="_blank">Read</a>
		</td>	
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='3'>No note found.</td>		
	</tr>
        <?php endif ?>
</table>
</div>


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
				url : '<?php echo site_url();?>/book_list/get_notebook',
				data: "class_id="+class_id+"&section_id="+section_id,
				success: function(response){  					
					$("#notebook").html(response);
				}
			});		
		});
    });
</script>
