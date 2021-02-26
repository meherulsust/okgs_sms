<?php $this->tpl->set_js('notebook_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-notebook" method='POST' action='<?php echo site_url($active_module.'/save') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>NOTE BOOK INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->nbform->render(); ?>
</table>
</fieldset>
	<?php echo $this->nbform->render_hidden(); ?>
</form>