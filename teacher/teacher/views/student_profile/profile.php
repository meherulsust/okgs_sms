<style type="text/css">
.profile tr td{
	padding:7px 10px;
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
			<td>Class </td>
			<td><b>:</b></td>
			<td><?php echo $class_name;?></td>			
		</tr>
		<tr>
			<td>Form </td>
			<td><b>:</b></td>
			<td><?php echo $section_name;?></td>			
		</tr>
		<tr>
			<td>Class Roll </td>
			<td><b>:</b></td>
			<td><?php echo $class_roll;?></td>			
		</tr>
		<tr>
			<td>Session </td>
			<td><b>:</b></td>
			<td><?php echo $session;?></td>			
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
</div>