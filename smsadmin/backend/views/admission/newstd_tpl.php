<?php $this->tpl->set_js('personal_info_form')?>
<form name='stdnew' method='POST' action='<?php echo site_url($active_module.'/newstd'); ?>' >

<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->piform->render(); ?>
</table>
	<?php echo $this->piform->render_hidden(); ?>
</form>