<?php ?>
<fieldset id="parents"><legend>ADDRESS</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th><label for="present_address">Present Addr : </label></th>
		<td><input name="present[address]" id="present_address" type="text" tabindex="1"
			class='required' value="<?php echo set_value('fathername'); ?>" /></td>
		<th><label for="permanent_address">Permanent Addr: </label></th>
		<td><input name="permanent[address]" id="permanent_address" type="text" tabindex="2"
			value="" /></td>
	</tr>

	<tr>
		<th><label for="persent_district">District: </label></th>
		<td><select  name="persent[district]" id="persent_district" tabindex="3">
		<?php echo html_model_options(array('model'=>'districtmodel','order_by'=>'name asc','value'=>'name','selected'=>'37'));?>
		</select></td>
		<th><label for="permanent_district">District: </label></th>
		<td><select  name="permanent[district]" id="permanent_district" tabindex="3">
		<?php echo html_model_options(array('model'=>'districtmodel','order_by'=>'name asc','value'=>'name','selected'=>'37'));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="persent_thana">Thana: </label></th>
		<td><select  name="persent[thana]" id="persent_thana" tabindex="3">
		<?php echo html_model_options(array('model'=>'thanamodel','order_by'=>'name asc','value'=>'name','selected'=>'303','where'=>'district_id=37'));?>
		</select></td>
		<th><label for="permanent_thana">Thana: </label></th>
		<td><select  name="permanent[thana]" id="permanent_thana" tabindex="3">
		<?php echo html_model_options(array('model'=>'thanamodel','order_by'=>'name asc','value'=>'name','selected'=>'303','where'=>'district_id=37'));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="persent_post_office">Post Office: </label></th>
		<td><select  name="persent[post_office]" id="persent_post_office" tabindex="3">
		<?php echo html_model_options(array('model'=>'postofcmodel','order_by'=>'name asc','value'=>'name','where'=>'thana_id=303'));?>
		</select></td>
		<th><label for="permanent_post_office">Post Office: </label></th>
		<td><select  name="permanent[post_office]" id="permanent_post_office" tabindex="3">
		<?php echo html_model_options(array('model'=>'postofcmodel','order_by'=>'name asc','value'=>'name','where'=>'thana_id=303'));?>
		</select></td>
	</tr>
	<tr>
		<th><label for="father_mobile">Mobile Number : </label></th>
		<td><input name="father[mobile]" id="father_mobile" type="text" tabindex="9"
			value="<?php echo set_value('mobile'); ?>" /></td>
		<th><label for="mother_mobile">Mobile Number : </label></th>
		<td><input name="mother[mobile]" id="mother_mobile" type="text" tabindex="10"
			value="<?php echo set_value('mobile'); ?>" /></td>
	</tr>
</table>
</fieldset>

