
 <h1>Class Routine</h1>
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
		<td align="center">
		<?php	
		foreach($routine_list as $routine){ 
			if($routine['class_day_id']==$day['id'] AND $routine['class_time_id']==$time['id']){
				echo $routine['subject'].'<br/>'.$routine['teacher_name'];
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
				url : '<?php echo site_url();?>/home/get_routine',
				data: "class_id="+class_id+"&section_id="+section_id,
				success: function(response){  					
					$("#routine").html(response);
				}
			});		
		});
    });
</script>


