<?php //$this->tpl->set_js('teacher_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-thana" name='<?php echo $this->tform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>THANA INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->tform->render(); ?>
</table>
</fieldset>
	<?php echo $this->tform->render_hidden(); ?>
</form>