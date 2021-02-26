<style type="text/css">
.profile tr td{
	padding:4px 10px;
}
#leftside {
	width: 78%;
	float: left;
}
#rightside {
	width: 20%;
	float: right;
	margin-top:-10px;
}
</style>

<div id="box">
	
	<h1>Profile Details</h1>
	<div id="leftside">
	<?php 

	foreach($details as $val){?>
	<table width="100%" class="profile">
		<tr>
			<td width="20%"><b>Name </b></td>
			<td><b>:</b></td>
			<td width="78%"><b><?php echo $val['teacher_name']; ?></b></td>			
		</tr>
		<tr>
			<td>Designation </td>
			<td><b>:</b></td>
			<td><?php echo $val['designation'];?></td>			
		</tr>
		<tr>
			<td>Date Of Birth </td>
			<td><b>:</b></td>
			<td><?php echo $val['dob'];?></td>			
		</tr>
		<tr>
			<td>Gender </td>
			<td><b>:</b></td>
			<td><?php echo $val['gender'];?></td>			
		</tr>
		<tr>
			<td>Blood Group </td>
			<td><b>:</b></td>
			<td><?php echo $val['blood_group'];?></td>			
		</tr>
		<tr>
			<td>Religion </td>
			<td><b>:</b></td>
			<td><?php echo $val['religion'];?></td>			
		</tr>
		<tr>
			<td>Address </td>
			<td><b>:</b></td>
			<td><?php echo $val['address']; ?></td>			
		</tr>
		<tr>
			<td>Mobile Number </td>
			<td><b>:</b></td>
			<td><?php echo $val['mobile_no']; ?></td>			
		</tr>
		<tr>
			<td>Email </td>
			<td><b>:</b></td>
			<td><?php echo $val['email']; ?></td>			
		</tr>
		<tr>
			<td>Subject </td>
			<td><b>:</b></td>
			<td><?php echo $val['subject']; ?></td>			
		</tr>

		
		<!--tr>
			<td align="center" colspan="2">
				<a href="<?=$site_url;?>topup_user/edit_profile"><b>Edit Profile</b></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	 
				<a href="<?=$site_url;?>topup_user/change_password"><b>Change Password</b></a>	
			</td>
		</tr-->
			
	</table>
	
	</div>
	<div id="rightside">
			<div width="50px;" style="float:right; margin-top:0px;">				
				<img src="<?php echo $admin_url.'uploads/teacher_photo/'.$val['photo'];?>" style="width:158px;"/>
			</div>
			<!-- <a class="button" style="cursor:pointer;text-decoration: none;" href="<?=$site_url;?>edit_profile/<?=$user_id;?>">Edit Profile</a> -->
			
	</div>
	<?php }?>
	
</div>