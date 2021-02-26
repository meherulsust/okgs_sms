<div class="table">
	<img src="<?php echo $image_url ?>bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo $image_url ?>bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="5">Search Center</th>
		</tr>									
		<tr>
			<td><strong>Select Your Search Criterion:</strong> </td>
			<td>
				<select name="cmbSearchCriterion">
					<option value="name">Name</option>
					<option value="card_no">Card No</option>
					<option value="designation">Designation</option>
					<option value="contact_no">Contact No</option>
					<option value="email">E-Mail</option>												
				</select>
			</td>
			<td><strong>Search For</strong> </td>
			<td><input type="text" name="txtSearchKey" /></td>
			<td><input type="image" src="<?php echo $image_url ?>button-sn.gif"  /></td>										
		</tr>
	</table>								
</div>	