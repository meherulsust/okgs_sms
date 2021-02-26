<?php //$this->tpl->set_js('photo_form');?>
<form name='frm-book' id='frm-book' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>BOOK INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->bookform->render(); ?>
</table>
</fieldset>
<?php echo $this->bookform->render_hidden(); ?>
</form>