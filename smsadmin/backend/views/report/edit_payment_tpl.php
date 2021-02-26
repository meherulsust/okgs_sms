<div id="box">
	<h3 id="adduser">Edit Payment </h3>
	<div id='std-create'>
		<?php $this->tpl->load_element('flash_message'); ?>
		<form id="frm-report" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/edit_payment/'.$fees['id']); ?>'>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->editpaymentform->render(); ?>
		</table>	
		<?php echo $this->editpaymentform->render_hidden(); ?>
		</form>
	</div>
</div>

