<fieldset id="parents"><legend>LOCAL GUARDIAN INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="name">Guardian Name : </label></th>
		<td><input name="name" id="name" type="text" tabindex="1"
			class='required' value="<?php echo set_value('name'); ?>" /></td>
		<th><label for="occupation">Occupation: </label></th>
		<td><select  name="occupation" id="occupation" tabindex="2">
		<?php echo html_model_options(array('model'=>'occupationmodel','selected'=>'1'));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="annual_income">Annual Income: </label></th>
		<td><input name="annual_income" id="annual_income" type="text" tabindex="3"
			value="<?php echo set_value('mobile'); ?>" /></td>
		<th><label for="email">Email: </label></th>
	<td><input name="email" id="email" type="text" tabindex="4"
			value="<?php echo set_value('email'); ?>" /></td>
	</tr>
	<tr>
		<th><label for="mobile">Mobile Number: </label></th>
		<td><input name="mobile" id="mobile" type="text" tabindex="5"
			value="<?php echo set_value('mobile'); ?>" /></td>
		<th><label for="relationship">Relationship: </label></th>
	<td><select  name="relationship" id="relationship" tabindex="6">
		<?php echo html_model_options(array('model'=>'relationshipmodel','selected'=>'1'));?>
		</select></td>
	</tr>
</table>
</fieldset>
<fieldset id="parents"><legend>LOCAL GUARDIAN ADDRESS</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="address_line">Address Line : </label></th>
		<td><input name="address" id="address" type="text" tabindex="7"
			class='required' value="<?php echo set_value('address'); ?>" /></td>
		<th><label for="district">District: </label></th>
		<td><select  name="district" id="district" tabindex="3">
		<?php echo html_model_options(array('model'=>'districtmodel','order_by'=>'name asc','value'=>'name','selected'=>'37'));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="thana">Thana: </label></th>
		<td><select  name="thana" id="thana" tabindex="3">
		<?php echo html_model_options(array('model'=>'thanamodel','order_by'=>'name asc','value'=>'name','selected'=>'303','where'=>'district_id=37'));?>
		</select></td>
		<th><label for="post_office">Post Office: </label></th>
		<td><select  name="post_office" id="post_office" tabindex="3">
		<?php echo html_model_options(array('model'=>'postofcmodel','order_by'=>'name asc','value'=>'name','where'=>'thana_id=303'));?>
		</select></td>
	</tr>
</table>
</fieldset>