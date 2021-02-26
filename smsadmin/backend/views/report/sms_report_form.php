<?php $this->tpl->load_element('flash_message');?>
<form id="frm-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/update_report'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->srform->render(); ?>
</table>	
<?php echo $this->srform->render_hidden(); ?>
</form>

