<?php $this->tpl->set_js($type.'_address_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-<?php echo $type ?>-address" name='<?php echo $this->adform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/asave/'.$type);  ?>' >
<fieldset id="personal"><legend><?php if($type=='present') echo 'PRESENT ADDRESS';  else echo 'PERMANENT ADDRESS'; ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
    <?php if($type=='present'):?>    
    <tr><th class="lbl"><label for="like_permanent">Same as Permanent</label></th><td class="cln">:</td><td><input name="like_permanent" value="" id="like_permanent"  type="checkbox"></tr>
    <?php endif ?>
	<?php echo $this->adform->render(); ?>
</table>
</fieldset>
	<?php echo $this->adform->render_hidden(); ?>
</form>