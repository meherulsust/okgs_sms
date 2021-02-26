
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
