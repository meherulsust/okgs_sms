<style>
.fieldwith{
	width:270px;
}
</style>
	<h1>Modify Profile</h1>
	<?php echo $this->session->flashdata('message'); ?>
	<?php  foreach($teacher as $val){?>
	<form action="<?=$site_url;?><?=$val['id']?>" method="post" enctype="multipart/form-data">	
		<table width="100%">
			<tr>
				<td width="25%"><text class="label">Name :</text></td>
				<td>
					<input  class="fieldwith textfield" type="text" name="teacher_name" value="<?=set_value('teacher_name',$val['teacher_name']);?>" tabindex="1"/>
					<span class="error">*</span> <?php echo form_error('teacher_name'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Designation :</text></td>
				<td>
					<select class="fieldwith textfield" name="designation_id">
						<option value="" >---- Select Designation ----</option>
						
						<?php	
						echo html_options($designation_options,set_value('designation_id',$val['designation_id'])) ;
						?>
					</select> 
					<span class='error'>* <?php echo form_error('designation_id'); ?></span>	
				</td>
			</tr>
			<tr>
				<td><text class="label">Username :</text></td>
				<td>
					<input class="fieldwith textfield" type="text" name="username" value="<?=set_value('username',$val['username']);?>" tabindex="3"/>
					<span class="error">*</span> <?php echo form_error('username'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Date Of Birth :</text></td>
				<td>
					<input class="fieldwith textfield" type="text" name="dob" value="<?=set_value('dob',$val['dob']);?>" tabindex="5"/>
					<span class="error">*</span> <?php echo form_error('dob'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Gender :</text></td>
				<td>
					<select class="fieldwith textfield" name="gender">
						<option value="" >---- Select Gender ----</option>
						<?php echo html_options($gender_options,set_value('gender',$val['gender'])) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('gender'); ?></span>	
				</td>
			</tr>
			<tr>
				<td><text class="label">Blood Group :</text></td>
				<td>
					<select  class="fieldwith textfield" name="blood_group_id">
						<option value="" >---- Select Blood Group ----</option>
						<?php echo html_options($blood_group_options,set_value('blood_group_id',$val['blood_group_id'])) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('blood_group_id'); ?></span>	
				</td>

			</tr>
			<tr>
				<td><text class="label">Religion :</text></td>
				<td>
					<select  class="fieldwith textfield" name="religion_id">
						<option value="" >---- Select Religion ----</option>
						<?php echo html_options($religion_options,set_value('religion_id',$val['religion_id'])) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('religion_id'); ?></span>	
				</td>
			</tr>
			<tr>
				<td><text class="label">Address :</text></td>
				<td>
					<textarea class="fieldwith textfield" name="address" tabindex="6" cols="20" rows="5"><?=set_value('address',$val['address']);?></textarea>
					
					<span class="error">*</span> <?php echo form_error('address'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Mobile No :</text></td>
				<td>
					<input class="fieldwith textfield" type="text" name="mobile_no" value="<?=set_value('mobile_no',$val['mobile_no']);?>" tabindex="10"/>
					<span class="error">*</span> <?php echo form_error('mobile_no'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">E-mail :</text></td>
				<td>
					<input class="fieldwith textfield" type="text" name="email" value="<?=set_value('email',$val['email']);?>" tabindex="11"/>
					<span class="error">*</span> <?php echo form_error('email'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Subject :</text></td>
				<td>
					<select  class="fieldwith textfield" name="relevant_subject_id">
						<option value="" >---- Select Subject ----</option>
						<?php echo html_options($subject_options,set_value('relevant_subject_id',$val['relevant_subject_id'])) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('relevant_subject_id'); ?></span>	
				</td>
			</tr>
			<tr>
				<td><text class="label">Photo :</text></td>
				<td>
					<input name="photo" type="file" class="fieldwith textfield"/>					                 
                    <span class='error'> <?php echo $upload_error; ?></span>
					
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<input type="submit" class="button" value="Update"/>
				</td>
			</tr>			
		</table>
	</form>
	<?php }?>
	</br>