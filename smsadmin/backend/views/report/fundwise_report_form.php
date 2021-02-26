<?php $this->tpl->load_element('flash_message');?>
<form name="fundwise-report" id="fundwise-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/fundwise_report_download'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->frform->render(); ?>
</table>	
</form>


