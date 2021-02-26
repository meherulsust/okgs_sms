<?php $this->tpl->set_js('personal_info_form')?>
<fieldset id="personal"><legend>PERSONAL INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="first_name">First name : </label></th>
		<td><input name="first_name" id="first_name" type="text" tabindex="1"
			class='required' value="<?php echo set_value('first_name',$first_name); ?>" /></td>
		<th><label for="last_name">Last name : </label></th>
		<td><input name="last_name" id="last_name" type="text" tabindex="2"
			value="<?php echo set_value('last_name',$last_name); ?>" /></td>
	</tr>
	<tr>
		<th><label for="datepicker">Date Of Birth : </label></th>
		<td><input name="datepicker" id="datepicker" type="text" tabindex="3"
			class='required' value="<?php echo set_value('datepicker',$datepicker); ?>" /></td>
		<th><label for="gender">Gender : </label></th>
		<td><select class='small' name="gender" id="gender" tabindex="4">
		<?php echo html_options(array('MALE'=>'Male','FEMALE'=>'Female'),$gender);?>
		</select></td>
	</tr>
	<tr>
		<th><label for="religion_id">Religion: </label></th>
		<td><select class='small' name="religion_id" id="religion_id" tabindex="5">
		<?php echo html_model_options(array('model'=>'religionmodel','selected'=>$religion_id));?>
		</select></td>
		<th><label for="caste_id">Caste : </label></th>
		<td><select class='small' name="caste_id" id="caste_id" tabindex="6">
		<?php echo html_model_options(array('model'=>'castemodel','order_by'=>'title asc','where'=>'religion_id='.$religion_id,'selected'=>$caste_id));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="is_tribe">Is Tribe: </label></th>
		<td><select class='small' name="is_tribe" id="is_tribe" tabindex="7">
		<?php echo html_options(array('NO'=>'No','YES'=>'Yes'),$is_tribe);?>
		</select></td>
		<th><label for="mobile">Contact Number : </label></th>
		<td><input name="mobile" id="mobile" type="text" tabindex="8"
			value="<?php echo set_value('mobile',$mobile); ?>" /></td>

	</tr>
	<tr>
		<th><label for="nationality">Nationality: </label></th>
		<td><select class='small' name="nationality_id" id="nationality_id"
			tabindex="5">
			<?php echo html_model_options(array('model'=>'nationalitymodel','selected'=>set_value('nationality_id',$nationality_id)));?>
		</select></td>
		<th><label for="comments">Comments:</label></th>
		<td><textarea name='comments' id='comments' style='height: 80px; width: 83%'></textarea></td>
	</tr>
</table>
<input type='hidden' id='dob' name='dob' value="<?php echo set_value('dob',$dob); ?>" />
<input type="hidden" id="id" name="id"  value="<?php echo @$id ?>"/>
</fieldset>
