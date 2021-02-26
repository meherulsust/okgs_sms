<?php $this->tpl->set_js('sylabus_course_attribute_form');?>
<form name='frm_sylabus_course_attribute' id='frm-sylabus-course-attribute' method='post' action='<?php echo site_url($active_module.'/saveattribute')?>' >
<fieldset id="sylabus_course_type"><legend><?php echo $form_title ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->scaform->render(); ?>
</table>
</fieldset>
<?php echo $this->scaform->render_hidden(); ?>
</form>