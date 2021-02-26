
<table width="80%" align="center" class="list_table" style="color:#fff;">	
	<tr height="55">
		<td bgcolor="#0099CC" align="center" style="font-weight:bold;">Teacher Routine List</td>
		<?php foreach($time_list as $time){ ?>	
		<td bgcolor="#0099CC" align="center"><b><?php echo $time['title']; ?></b></td>	
		<?php }	?>	
	</tr>
	
	<?php foreach($day_list as $day){ ?>
	<tr height="55">
		<td bgcolor="#0099CC" align="center"><b><?php echo $day['title']; ?></b></td>
		<?php 
		foreach($time_list as $time){
		?>
		<td align="center" style="font-weight:bold;color:#FFF; background-color:#006699;">
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
