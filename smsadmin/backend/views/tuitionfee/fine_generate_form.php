<div id="box">
	<div id='book-create'>
		<form name='frm-tf-form' id='frm-book' method='post' action='<?php echo site_url($active_module.'/fine_generate')?>' >
			<fieldset id="personal"><legend>GENERATE FINE</legend>
			<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
				<?php echo $this->fgform->render(); ?>
			</table>
			</fieldset>			
		</form>
</div>
