<?php $this->tpl->set_js(array('classtest_form'));?>
<form name='frm-classtest' id='frm-classtest' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ctform->render(); ?>
</table>
<?php echo $this->ctform->render_hidden(); ?>
</form>