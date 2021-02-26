<?php  $this->tpl->load_element('flash_message'); ?>
<div id='change-pass'>
<form name='frm-chpass' id='frm-chpass' method='post' action='<?php echo site_url($active_module.'/savepass')?>' >
<fieldset id="personal"><legend>PASSWORD CHANGE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<tr>
		<th class="lbl"><label for="old_password">Old Password</label></th><td class="cln">:</td>
                <td><input name="old_password" id="old_password" class="txt" type="password"><span class="req">*</span></td>
         </tr>
         <tr>
		<th class="lbl"><label for="password">New Password</label></th><td class="cln">:</td>
                <td><input name="password" id="password" class="txt" type="password"><span class="req">*</span></td>
         </tr>
         <tr>
		<th class="lbl"><label for="re_password">Retype Password</label></th><td class="cln">:</td>
                <td><input name="re_password" id="re_password" class="txt" type="password"><span class="req">*</span></td>
         </tr>
         <td>&nbsp;</td>
 <td class="btn-container" colspan="2">
<input class="btn" type="submit" value="Submit" name="submit">
<input class="btn" type="reset" value="Reset" name="button">
<button class="btn" id="btn-cancel" type="button">Cancel</button>
</td>
</table>
</fieldset>
</form>
</div>

