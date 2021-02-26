<?php $this->tpl->load_element('flash_message');?>
<?php $this->tpl->set_js('admission_form');?>
<form name='frm_admission' id='frm_admission' method='post' action='<?php echo site_url($active_module.'/saveadmission')?>' >
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->adform->render(); ?>
</table>
<?php echo $this->adform->render_hidden(); ?>
</form>