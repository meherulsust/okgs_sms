<?php $this->tpl->set_js('sylabus_form');?>
<form name='frm-sylabus' id='frm-sylabus' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>SYLLABUS INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sform->render(); ?>
</table>
</fieldset>
<?php echo $this->sform->render_hidden(); ?>
</form>