<?php $this->tpl->set_js('sylabus_course_type_form');?>
<form name='frm_sylabus_course_type' id='frm-sylabus-course-type' method='post' action='<?php echo site_url($active_module.'/savesctype')?>' >
<fieldset id="sylabus_course_type"><legend><?php echo $form_title ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sctform->render(); ?>
</table>
</fieldset>
<?php echo $this->sctform->render_hidden(); ?>
</form>