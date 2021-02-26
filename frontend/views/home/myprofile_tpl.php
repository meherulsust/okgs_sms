<style type="text/css">
.profile tr td{
	padding:4px 10px;
}
</style>

<div id="box">
	<?php echo $this->session->flashdata('message'); ?>
	<h1>Profile Details</h1>
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
		<tr>
			<td>Mobile Number </td>
			<td><b>:</b></td>
			<td><?php echo $mobile; ?></td>			
		</tr>
		<tr>
			<td>Date of Birth </td>
			<td><b>:</b></td>
			<td><?php echo $dob; ?></td>			
		</tr>
		<!--
		<tr>
			<td align="center" colspan="2">
				<a href="<?=$site_url;?>topup_user/edit_profile"><b>Edit Profile</b></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	 
				<a href="<?=$site_url;?>topup_user/change_password"><b>Change Password</b></a>	
			</td>
		</tr>
		-->	
	</table>
	<h1>Guardian Info</h1>
	<table width="100%" class="profile">
		<tr>
			<td width="20%">Father's Name</td>
			<td><b>:</b></td>
			<td width="78%"><?php echo $father_name; ?></td>			
		</tr>
		<tr>
			<td>Mother's Name </td>
			<td><b>:</b></td>
			<td><?php echo $mother_name;?></td>			
		</tr>			
	</table>
</div>
