<h1>Student Login</h1>
</br>
<form action="<?=$site_url;?>login/logged" method="post">
	<table width="400px" style="border:1px solid #ddd;" align="center">
		<tr>
			<td width="25%"></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<span class="example">Please insert valid email and password to login.</span>
				<?php echo $this->session->flashdata('error_message'); ?>
			</td>
		</tr>
		<tr>
			<td><text class="label">Username :</text></td>
			<td><input class="textfield" type="text" name="username"/></td>
		</tr>
		<tr>
			<td><text class="label">Password :</text></td>
			<td><input class="textfield" type="password" name="password"/></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input  class="button" type="submit" value="Login"/>
				<!-- &nbsp;&nbsp;<b><a href="<?=$site_url;?>login/forgot_password">Forgot your password?</a></b>  -->
			</td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>