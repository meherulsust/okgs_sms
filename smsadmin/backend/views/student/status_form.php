<?php $this->tpl->set_js('student_status_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-student-status" name='<?php echo $this->ssform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/sstatussave/');  ?>' >
<fieldset id="personal"><legend><?php echo 'STUDENT STATUS INFORMATION' ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ssform->render(); ?>
</table>
</fieldset>
	<?php echo $this->ssform->render_hidden(); ?>
</form>