<?php //$this->tpl->set_js('course_title_form');?>
<form enctype="multipart/form-data"  name='frm-school' id='frm-school' method='post' action='<?php echo site_url($active_module.'/saveinfo')?>' >
<fieldset id="personal"><legend>SCHOOL INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sform->render(); ?>
</table>
</fieldset>
<?php echo $this->sform->render_hidden(); ?>
</form>