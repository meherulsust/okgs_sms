<?php $this->tpl->set_js(array('course_form'));?>
<form name='frm-course' id='frm-course' method='post' action='<?php echo site_url($active_module.'/savecourse/'.$sylabus_id)?>' >
<fieldset id="sylabus_evaluation_type"><legend><?php echo $form_title ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->courseform->render(); ?>
	
</table>
</fieldset>
<?php echo $this->courseform->render_hidden(); ?>
</form>
