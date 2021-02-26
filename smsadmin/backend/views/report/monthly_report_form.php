<?php $this->tpl->load_element('flash_message');?>
<form name="monthly-report" id="monthly-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/monthly_report_download'); ?>'>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->mrform->render(); ?>
</table>	
</form>


