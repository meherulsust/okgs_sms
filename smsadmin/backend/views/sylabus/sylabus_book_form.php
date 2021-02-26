<?php $this->tpl->set_js(array('jquery.validate','sylabus_book_form'));?>
<form name='frm-sylabus-book' id='frm-sylabus-book' method='post' action='<?php echo site_url($active_module.'/sbsave')?>' >
<fieldset id="personal"><legend>SYLABUS BOOK INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->sbform->render(); ?>
</table>
</fieldset>
<?php echo $this->sbform->render_hidden(); ?>
</form>