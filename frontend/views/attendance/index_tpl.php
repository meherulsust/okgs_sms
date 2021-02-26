<div>
    <h1>Attendance Information</h1>
	<table width="100%" class="profile">
		<tr>
			<td width="20%"><b>Name </b></td>
			<td><b>:</b></td>
			<td width="78%"><b><?php echo $first_name.' '.$last_name; ?></b></td>			
		</tr>
		<tr>
			<td>Student Number </td>
			<td><b>:</b></td>
			<td><?php echo $student_number;?></td>			
		</tr>
		<tr>
			<td>Version </td>
			<td><b>:</b></td>
			<td><?php echo $version;?></td>			
		</tr>
		<tr>
			<td>Class </td>
			<td><b>:</b></td>
			<td><?php echo $class;?></td>			
		</tr>
		<tr>
			<td>Form </td>
			<td><b>:</b></td>
			<td><?php echo $section;?></td>			
		</tr>
		<tr>
			<td>Class Roll </td>
			<td><b>:</b></td>
			<td><?php echo $class_roll;?></td>			
		</tr>
		<tr>
			<td>Gender </td>
			<td><b>:</b></td>
			<td><?php echo $gender; ?></td>			
		</tr>
	</table>
	<table class="list_table">
		<tr>
			<th>TOTAL WORKING DAYS</th>	
			<th>TOTAL  ATTENDANCE</th>	
			<th>TOTAL  ABSENCE</th>		
		</tr>
		<tr style="text-align:center">
			<td><?php echo $working_days;?></td>
			<td><?php echo $total_attendance?></td>
			<td><?php echo $total_adsence?></td>
		</tr>
	</table>
</div>
