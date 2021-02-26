<div id="box">
<h3>Personal information of <i><?php echo $first_name.' '.$last_name ?></i></h3>
<table width='800' border='0' cellspacing='0' cellpadding='0' id='profile'>
	<tr>
		<th>First Name:</th>
		<td><?php echo $first_name ?></td>
		<th>Last Name:</th>
		<td><?php echo $last_name ?></td>
		<th>Gender:</th>
		<td><?php echo ucfirst($gender) ?></td>
	</tr>
	<tr>
		<th>Naionality:</th>
		<td><?php echo $nationality ?></td>
		<th>Student Number:</th>
		<td><?php echo $student_number ?></td>
		<th>Date of Birth:</th>
		<td><?php echo $dob; ?></td>
	</tr>
	
	<tr>
	    <th>Tribe:</th>
		<td><?php echo ucfirst($tribe) ?></td>
		<th>Contact Number:</th>
		<td><?php echo $mobile ?></td>
		<th>E-Mail:</th>
		<td><?php echo $email ?></td>
	</tr>
	<tr>
		<th>Status:</th>
		<td><?php echo $status; ?></td>
		<th>Created At:</th>
		<td><?php echo $created_on ;?></td>
		<th>Created By:</th>
		<td><?php echo $created_by; ?></td>
	</tr>
	<tr>
		<th>Comments:</th>
		<td colspan='5'><?php echo $comments ?></td>
	</tr>
</table>
<img class='border' src='<?php echo $image_url ?>nophoto.jpg'
	width='100' height='100' style='float: right' />
<div class='clr'></div>
<div id='mtab'>
<ul>
	<li><a href="<?php echo site_url('student/personal/type/personal/std_id/'.$id.'/id/'.$personal_details_id.'/actn/view')?>" title='Personal Information'>Personal Info</a></li>
	<li><a href="<?php echo site_url('student/personal/type/parents/std_id/'.$id.'/actn/view/id/'.$parent_id)?>" title='Parents'>Parents</a></li>
	<li><a href="<?php echo site_url('student/personal/type/address/std_id/'.$id.'/id/'.$id.'/actn/view')?>" title='Address'>Address</a></li>
	<li><a href="<?php echo site_url('student/personal/type/guardian/std_id/'.$id.'/id/'.$id.'/actn/view')?>" title="Local Guardian">Guardian</a></li>
	<li><a href="<?php echo site_url('student/personal/type/photo/std_id/'.$id.'/id/'.$id.'/actn/view')?>" title="Picture">Photo</a></li>
</ul>
</div>

</div>
<script language='javascript'>
var stab;
$(document).ready(function(){
	stab = $("#mtab" ).tabs(); 
});
</script>
