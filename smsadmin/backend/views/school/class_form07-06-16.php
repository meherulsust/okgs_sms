<form  id="frm-class" name='<?php echo $this->cform->get_name() ?>' method='post' action='<?php echo site_url($active_module.'/csave');  ?>' >
<fieldset id="class"><legend>SCHOOL CLASS INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->cform->render(); ?>
</table>
</fieldset>
	<?php echo $this->cform->render_hidden(); ?>
</form>