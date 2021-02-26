<fieldset id="parents"><legend>FATHER'S INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="father_first_name">First name : </label></th>
		<td><input name="father[first_name]" id="father_first_name" type="text" tabindex="1"
			class='required' value="<?php echo set_value('father[first_name]',$father['first_name']); ?>" /></td>
		<th><label for="father_last_name">Last name : </label></th>
		<td><input name="father[last_name]" id="father_last_name" type="text" tabindex="2"
			value="" /></td>
	</tr>

	<tr>
		<th><label for="father_occupation">Occupation: </label></th>
		<td><select  name="father[occupation]" id="father_occupation" tabindex="3">
		<?php echo html_model_options(array('model'=>'occupationmodel','selected'=>$father['occupation_id']));?>
		</select></td>
		<th><label for="father_annual_income">Annual Income: </label></th>
		<td><input name="father[annual_income]" id="father_annual_income" type="text" tabindex="5"
			value="<?php echo set_value('father[annual_income]'); ?>" /></td>
	</tr>
	<tr>
		<th><label for="father_email">Email: </label></th>
	<td><input name="father[email]" id="father_email" type="text" tabindex="7"
			value="<?php echo set_value('email'); ?>" /></td>
		<th><label for="father_mobile">Mobile Number : </label></th>
		<td><input name="father[mobile]" id="father_mobile" type="text" tabindex="9"
			value="<?php echo set_value('mobile'); ?>" /></td>
	</tr>

</table>
</fieldset>
<fieldset><legend>MOTHER'S INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="mother_first_name">First name : </label></th>
		<td><input name="mother[first_name]" id="mother_first_name" type="text" tabindex="1"
			class='required' value="<?php echo set_value('mother[first_name]',$mother['first_name']); ?>" /></td>
		<th><label for="mother_last_name">Last name : </label></th>
		<td><input name="mother[last_name]" id="mother_last_name" type="text" tabindex="2"
			value="" /></td>
	</tr>


	<tr>
		<th><label for="mother_occupation">Occupation: </label></th>
		<td><select  name="mother[occupation]" id="mother_occupation" tabindex="4">
		<?php echo html_model_options(array('model'=>'occupationmodel','selected'=>$mother['occupation_id']));?>
		</select></td>
		
		<th><label for="mother_annual_income">Annual Income: </label></th>
		<td><input name="mother[annual_income]" id="mother_annual_income" type="text" tabindex="6"
			value="<?php echo set_value('mobile'); ?>" /></td>

	</tr>
	<tr>
		<th><label for="mother_mobile">Mobile Number : </label></th>
		<td><input name="mother[mobile]" id="mother_mobile" type="text" tabindex="7"
			value="<?php echo set_value('mobile'); ?>" /></td>
		

		<th><label for="mother_email">Email: </label></th>
		<td><input name="mother[email]" id="mother_email" type="text" tabindex="8"
			value="<?php echo set_value('mobile'); ?>" /></td>

	</tr>
</table>
</fieldset>
<input type='hidden' name='student_id' value=<?php echo $student_id ?> />
<input type='hidden' name='father["relationship_id"]' value='2' />
<input type='hidden' name='mother"relationship_id"]' value='1' />




