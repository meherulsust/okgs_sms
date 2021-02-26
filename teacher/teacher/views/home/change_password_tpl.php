<h1>Change Password</h1>
<?php echo $this->session->flashdata('message'); ?>
<form action="<?php echo site_url('home/change_password'); ?>"  method="post">
	<table width="95%" align="center">
		<tr>
			<td width="20%"></td>
			<td></td>
		</tr>		
		<tr>
			<td><text class="label">Old Password :</text></td>
			<td><input class="textfield" type="password" name="old_password"/><span class="error"> * <?php echo form_error('old_password');?></span></td>
		</tr>
		<tr>
			<td><text class="label">New Password :</text></td>
			<td><input class="textfield" type="password" name="new_password"/><span class="error"> * <?php echo form_error('new_password');?></span></td>
		</tr>
		<tr>
			<td><text class="label">Re-type Password :</text></td>
			<td><input class="textfield" type="password" name="retype_password"/><span class="error"> * <?php echo form_error('retype_password');?></span></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input  class="button" type="submit" value="Update Password"/>				
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
