<?php $this->tpl->set_js('course_attribute_form');?>
<form name='frm-result-scale' id='frm-result-scale' method='post' action='<?php echo site_url($active_module.'/savecattr')?>' >
<fieldset id="courseattribute"><legend>COURSE ATTRIBUTE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->caform->render(); ?>
</table>
</fieldset>
<?php echo $this->caform->render_hidden(); ?>
</form>