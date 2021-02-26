<h1>Forgot Password</h1>
<form action="<?=$site_url;?>login/forgot_password" method="post">
	<table width="400px" style="border:1px solid #ddd;" align="center">
		<tr>
			<td width="25%"></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<span class="example">Please insert valid email.</span>
				<div class="error"><?php echo form_error('email'); ?></div>
				<?php echo $this->session->flashdata('message'); ?>
			</td>
		</tr>
		<tr>
			<td><text class="label">Email :</text></td>
			<td><input class="textfield" type="text" name="email"/></td>
		</tr>		
		<tr>
			<td></td>
			<td>
				<input  class="button" type="submit" value="Submit"/>
				&nbsp;&nbsp;<b><a href="<?=$site_url;?>/registration">Back To Login ?</a></b>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>