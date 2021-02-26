<div id="box">
	<h3 id="adduser">Student Details</h3>	
</div>	
<fieldset>
	<legend>PERSONAL INFORMATION</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="20%"><b>Student Number </b></td>
				<td width="35%"><b>:</b> <b><?php echo $student_number; ?></b></td>
				<td width="20%"></td>
				<td width="25%" rowspan="4">
					<img class="border" id="std-img" src="<?php echo base_url() . "uploads/std_photo/" . $image_file ?>" width="150" height="150" style="float: right" />
				</td>	
			</tr>
			<tr>				
				<td width="20%"><b>Student Name </b></td>
				<td width="35%"><b>:</b> <b><?php echo $full_name; ?></b></td>
				<td></td>				
			</tr>
			<tr>				
				<td><b>Class </b></td>
				<td><b>:</b> <?php echo $class; ?></td>
				<td></td>				
			</tr>
			<tr>				
				<td><b>Form </b></td>
				<td><b>:</b> <?php echo $section; ?></td>
				<td></td>				
			</tr>
			<tr>				
				<td><b>Class Roll </b></td>
				<td><b>:</b> <?php echo $class_roll; ?></td>
				<td></td>				
			</tr>
			<tr>				
				<td><b>Board Roll </b></td>
				<td><b>:</b> <?php echo $board_roll; ?></td>
				<td><b>Board Regi. No. </b></td>
				<td><b>:</b> <?php echo $board_regino; ?></td>
			</tr>
			<tr>				
				<td><b>Session </b></td>
				<td><b>:</b> <?php echo $student_session; ?></td>
				<td><b>Gender </b></td>
				<td><b>:</b> <?php echo $gender; ?></td>
			</tr>
			<tr>				
				<td><b>Student Type </b></td>
				<td><b>:</b> <?php echo $student_type; ?></td>
				<td><b>Date of Birth </b></td>
				<td><b>:</b> <?php echo $dob; ?></td>
			</tr>
			<tr>				
				<td><b>Version/Medium </b></td>
				<td><b>:</b> <?php echo $version; ?></td>
				<td><b>Birth Registration No. :</b></td>
				<td><?php echo $birth_reg_no; ?></td>
			</tr>
			<tr>				
				<td><b>Nationality </b></td>
				<td><b>:</b> <?php echo $nationality; ?></td>
				<td><b>Religion </b></td>
				<td><b>:</b> <?php echo $religion; ?></td>
			</tr>
			<tr>				
				<td><b>Is Tribe </b></td>
				<td><b>:</b> <?php echo $is_tribe; ?></td>								
				<td><b>Blood Group  </b></td>
				<td><b>:</b> <?php echo $blood_group; ?></td>			
			</tr>			
		</tbody>	
	</table>	
</fieldset>
<fieldset style="width:31%;float:left;">
	<legend>FATHER'S INFORMATION</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="35%"><b>Father's Name </b></td>
				<td width="65%"><b>:</b> <?php echo $father_name; ?></td>					
			</tr>
			<tr>				
				<td><b>Annual Income </b></td>
				<td><b>:</b> <?php echo $father_monthly_income; ?></td>								
			</tr>
			<tr>				
				<td><b>Occupation </b></td>
				<td><b>:</b> <?php echo $father_occupation; ?></td>								
			</tr>
			<tr>				
				<td><b>NID </b></td>
				<td><b>:</b> <?php echo $father_national_id; ?></td>								
			</tr>
			<tr>				
				<td><b>Mobile </b></td>
				<td><b>:</b> <?php echo $father_mobile; ?></td>								
			</tr>			
		</tbody>	
	</table>	
</fieldset>
<fieldset style="width:31%;float:left;margin-left:4px;">
	<legend>MOTHER'S INFORMATION</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="35%"><b>Mother's Name </b></td>
				<td width="65%"><b>:</b> <?php echo $mother_name; ?></td>					
			</tr>
			<tr>				
				<td><b>Annual Income </b></td>
				<td><b>:</b> <?php echo $mother_monthly_income; ?></td>								
			</tr>
			<tr>				
				<td><b>Occupation </b></td>
				<td><b>:</b> <?php echo $mother_occupation; ?></td>								
			</tr>
			<tr>				
				<td><b>NID </b></td>
				<td><b>:</b> <?php echo $mother_national_id; ?></td>								
			</tr>
			<tr>				
				<td><b>Mobile </b></td>
				<td><b>:</b> <?php echo $mother_mobile; ?></td>								
			</tr>			
		</tbody>	
	</table>	
</fieldset>
<fieldset style="width:31%;float:right;">
	<legend>LOCAL GUARDIAN INFORMATION</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="35%"><b>Guardian Name </b></td>
				<td width="65%"><b>:</b> <?php echo $local_guardian_name; ?></td>					
			</tr>
			<tr>				
				<td><b>Relationship Name </b></td>
				<td><b>:</b> <?php echo $relationship; ?></td>								
			</tr>
			<tr>				
				<td><b>Occupation </b></td>
				<td><b>:</b> <?php echo $local_guardian_occupation; ?></td>								
			</tr>
			<tr>				
				<td><b>NID </b></td>
				<td><b>:</b> <?php echo $local_guardian_national_id; ?></td>								
			</tr>
			<tr>				
				<td><b>Mobile </b></td>
				<td><b>:</b> <?php echo $local_guardian_mobile; ?></td>								
			</tr>			
		</tbody>	
	</table>	
</fieldset>
<fieldset style="width:47%;float:left;">
	<legend>PRESENT ADDRESS</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="35%"><b>Address </b></td>
				<td width="65%"><b>:</b> <?php echo $present_address; ?></td>					
			</tr>
			<tr>				
				<td><b>District </b></td>
				<td><b>:</b> <?php echo $present_district; ?></td>								
			</tr>
			<tr>				
				<td><b>Thana </b></td>
				<td><b>:</b> <?php echo $present_thana; ?></td>								
			</tr>
			<tr>				
				<td><b>Post Office </b></td>
				<td><b>:</b> <?php echo $present_post; ?></td>								
			</tr>			
		</tbody>	
	</table>	
</fieldset>
<fieldset style="width:47%;float:right;">
	<legend>PERMANENT ADDRESS</legend>
	<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
		<tbody>			
			<tr>				
				<td width="35%"><b>Address </b></td>
				<td width="65%"><b>:</b> <?php echo $parmanent_address; ?></td>					
			</tr>
			<tr>				
				<td><b>District </b></td>
				<td><b>:</b> <?php echo $parmanent_district; ?></td>								
			</tr>
			<tr>				
				<td><b>Thana </b></td>
				<td><b>:</b> <?php echo $parmanent_thana; ?></td>								
			</tr>
			<tr>				
				<td><b>Post Office </b></td>
				<td><b>:</b> <?php echo $parmanent_post; ?></td>								
			</tr>			
		</tbody>	
	</table>	
</fieldset>
		