<?php $this->tpl->set_js('section_form'); ?>
<form  id="frm-section" name='<?php echo $this->secform->get_name() ?>' method='post' action='<?php echo site_url($active_module.'/savesec');  ?>' >
<fieldset id="class"><legend>NEW SECTION INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->secform->render(); ?>
</table>
</fieldset>
	<?php echo $this->secform->render_hidden(); ?>
</form>