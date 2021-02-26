	<h1>Contact Us</h1>
	<?php echo $this->session->flashdata('message'); ?>
	<form action="<?=$site_url;?>home/contact_us" method="post">	
		<table width="100%">
			<tr>
				<td width="25%"><text class="label">Full Name :</text></td>
				<td>
					<input class="textfield" type="text" name="name" value="<?=set_value('name');?>" tabindex="1"/>
					<span class="error">*</span> <?php echo form_error('name'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Contact Number :</text></td>
				<td>
					<input class="textfield" type="text" name="contact_no" value="<?=set_value('contact_no');?>" tabindex="2"/>
					<span class="error">*</span> <?php echo form_error('contact_no'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Location :</text></td>
				<td>
					<input class="textfield" type="text" name="location" value="<?=set_value('location');?>" tabindex="3"/>
					<span class="error">*</span> <?php echo form_error('location'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">E-mail :</text></td>
				<td>
					<input class="textfield" type="text" name="email" value="<?=set_value('email');?>" tabindex="4"/>
					<span class="error">*</span> <?php echo form_error('email'); ?>
				</td>
			</tr>
			<tr>
				<td><text class="label">Subject :</text></td>
				<td>
					<input class="textfield" type="text" name="subject" value="<?=set_value('subject');?>" tabindex="5"/>
					<span class="error">* </span><?php echo form_error('subject'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top"><text class="label">Message :</text></td>
				<td>
					<textarea class="textfield" name="message" tabindex="6" cols="50" rows="5"><?=set_value('message');?></textarea>
					<span class="error">* </span></br><?php echo form_error('message'); ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php echo $cap_img; ?>	<span class="example"> [ Case sensitive characters ] </span>				
				</td>
			</tr>
			<tr>
				<td><text class="label">Security code :</text></td>
				<td>
					<input class="textfield" type="text" name="captcha" tabindex="7"/>
					<span class="error">*</span> <?php echo form_error('captcha'); ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="button" value="Submit"/>
					<input type="reset" class="button" value="Reset"/>
				</td>
			</tr>			
		</table>
	</form>
	</br>