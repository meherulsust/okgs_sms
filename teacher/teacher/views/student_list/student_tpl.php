<h1>Student List</h1>
<form action="#" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Select Class </b></td>
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
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Select Form</b> </td>
		<td>
			<select class="textfield" id="section_id" name="section_id">
				<option value="">---Select Section--</option>				  
			</select>	
		</td>			
	</tr>
</table>
</form>
<div id="student_list">
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

	<tr>
		<td align="center" colspan='7'>No Student List found.</td>		
	</tr>
        
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
				url : '<?php echo site_url();?>/student_list/get_student',
				data: "class_id="+class_id+"&section_id="+section_id,
				success: function(response){  					
					$("#student_list").html(response);
				}
			});		
		});
    });
</script>
