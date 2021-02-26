
 <h1>Teacher Class Routine</h1>
<form action="#" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Select Class</b></td>
		<td>
		<b>
			<select class="textfield" id="class_id" name="class_id">
			<option value="">---Select Class--</option>
			  <?php foreach($get_class as $val){?>
			  <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
			  <?php }?>
			</select>		
		</b>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Select Teacher</b> </td>
		<td>
			<select class="textfield" id="teacher_id" name="teacher_id">
				<option value="">---Select Teacher--</option>				  
			</select>	
		</td>			
	</tr>
</table>
</form>
<div id="routine">	
<table width="80%" align="center" class="list_table">	
	<tr height="55">
		<td bgcolor="AEECE7"></td>
		<?php foreach($time_list as $time){ ?>	
		<td bgcolor="AEECE7" align="center"><b><?php echo $time['title']; ?></b></td>	
		<?php }	?>	
	</tr>
	<?php foreach($day_list as $day){ ?>
	<tr height="55">
		<td bgcolor="#C7F2EE" align="center"><b><?php echo $day['title']; ?></b></td>
		<?php 
		foreach($time_list as $time){
		?>
		<td align="center"style="font-weight:bold;">
		<?php	
		foreach($routine_list as $routine){ 
			if($routine['class_day_id']==$day['id'] AND $routine['class_time_id']==$time['id']){
				echo $routine['subject'].'<br/>'.$routine['section_title'];
			}
		}	
		?>	
		</td>				
		<?php 				
		
		}
		?>
	</tr>
	<?php } ?>       
</table>
</div>

<script>
	$(document).ready(function(){  
		$('#class_id').selectChain({
			target: $('#teacher_id'),
			value:'name',
			url: '<?php echo site_url();?>/teacher_routine/teacher',
			type: 'post',
			data:{'class_id': 'class_id' }
		}); 
		
		$('#teacher_id').change(function(){
			var class_id = $('#class_id').val();
			var teacher_id = $(this).val();
			$.ajax({
				type: "POST",
				url : '<?php echo site_url();?>/teacher_routine/get_routine',
				data: "class_id="+class_id+"&teacher_id="+teacher_id,
				success: function(response){  					
					$("#routine").html(response);
				}
			});		
		});
    });
</script>


