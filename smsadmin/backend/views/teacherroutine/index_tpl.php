<div id="box">
	<h3 id="adduser">Teacher Routine</h3>
	<div id='std-create'>
		<form id="frm-generate Payment" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/class_routine'); ?>'>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->teacher_routineform->render(); ?>
		</table>	
		<?php echo $this->teacher_routineform->render_hidden(); ?>
		</form>
	</div>
</div>