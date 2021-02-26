<?php $this->tpl->set_js('sylabus_exam_type_form');?>
<form name='frm_sylabus_exam_type' id='frm-sylabus-exam-type' method='post' action='<?php echo site_url($active_module.'/saveexamtype')?>' >
<fieldset id="sylabus_exam_type"><legend><?php echo $form_title ?></legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->setform->render(); ?>
</table>
</fieldset>
<?php echo $this->setform->render_hidden(); ?>
</form>