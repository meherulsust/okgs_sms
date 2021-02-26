<?php //$this->tpl->set_js('course_title_form');?>
<form name='frm-course-title' id='frm-course-title' method='post' action='<?php echo site_url($active_module.'/savect')?>' >
<fieldset id="personal"><legend>COURSE TITLE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctform->render(); ?>
</table>
</fieldset>
<?php echo $this->ctform->render_hidden(); ?>
</form>