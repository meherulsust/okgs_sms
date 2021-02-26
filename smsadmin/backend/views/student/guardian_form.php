<?php $this->tpl->set_js($type.'_info_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-<?php echo $type ?>-info" name='<?php echo $this->gdform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/gsave/'.$type);  ?>' >
<fieldset id="personal"><legend><?php if($type=='father') echo 'FATHER\'S INFORMATION'; elseif($type=='mother')   echo 'MOTHER\'S INFORMATION'; else echo 'LOCAL GUARDIAN\'S INFORMATION'; ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->gdform->render(); ?>
</table>
</fieldset>
	<?php echo $this->gdform->render_hidden(); ?>
</form>