<?php $this->tpl->set_js('view_toolbar') ?>
<?php $this->tpl->load_element('flash_message');?>
<fieldset id="parents"><legend>PERSONAL INFORMATION</legend>
<table border='0' cellpadding='0' cellspacing='0' class='info-tbl'>
	<tr>
		<th>First name :</th><td><?php echo $first_name ?></td>
		<th>Last name :</th><td><?php echo $last_name ?></td>
		<th>Date of Birth :</th><td><?php echo $dob; ?></td>
	</tr>
	<tr>
		<th>Gender :</th><td><?php echo ucfirst($gender) ?></td>
		<th>Religion :</th><td><?php echo ucfirst($religion) ?></td>
		<th>Caste :</th><td><?php echo ucfirst($caste) ?></td>
	</tr>
	<tr>
		<th>Mobile :</th><td><?php echo $mobile ?></td>
		<th>Email :</th><td><?php echo $email ?></td>
		<th>Nationality :</th><td><?php echo ucfirst($nationality) ?></td>
	</tr>
	<tr>
		<th>Last Update Date :</th><td><?php echo $updated_on ?></td>
		<th>Updated By :</th><td><?php echo $updated_by ?></td>
		<th>Tribe :</th><td><?php echo ucfirst($tribe) ?></td>
	</tr>
	<tr><td colspan='6' class='toolbar'><a class='edit' href='<?php echo site_url('student/personal/'.$std_id.'/'.$personal_details_id.'/edit')?>' id='lnk-edit'>
	<img src="<?php echo $image_url?>a_edit.gif"  alt='Edit' title='Edit Personal Information' />
	</a></td></tr>
</table>
</fieldset>