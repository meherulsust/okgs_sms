
<div id="box">
	<h3 id="adduser">Generate Payment</h3>
	<div id='std-create'>
		<form id="frm-generate Payment" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/make_advp/'.$id); ?>'>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->make_advpform->render(); ?>
		</table>	
		<?php echo $this->make_advpform->render_hidden(); ?>
		</form>
	</div>
</div>

