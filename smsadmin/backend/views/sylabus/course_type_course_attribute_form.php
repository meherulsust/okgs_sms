<?php $this->tpl->set_js(array('course_type_course_attribute_form'));?>
<form name='frm-ctca' id='frm-ctca' method='post' action='<?php echo site_url($active_module.'/savectattr')?>' >
<fieldset id="ctca"><legend>COURSE TYPE COURSE ATTRIBUTE</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctcaform->render(); ?>
</table>
</fieldset>
<?php echo $this->ctcaform->render_hidden(); ?>
</form>