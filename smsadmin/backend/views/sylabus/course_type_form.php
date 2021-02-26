<?php $this->tpl->set_js('course_type_form');?>
<form name='frm-course-type' id='frm-course-type' method='post' action='<?php echo site_url($active_module.'/savectype')?>' >
<fieldset id="coursetype"><legend>COURSE TYPE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctform->render(); ?>
</table>
</fieldset>
<?php echo $this->ctform->render_hidden(); ?>
</form>