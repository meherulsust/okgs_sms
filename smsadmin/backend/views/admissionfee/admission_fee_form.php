<?php   
        $this->tpl->set_jquery_ui(array('position', 'dialog'));
        $this->tpl->set_js(array('admission_fee_form','jquery.validate','jquery.loadmask'));
        $this->tpl->set_css(array('jquery.loadmask'));
 ?>
<form name='frm-atf' id='frm-atf' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>STUDENT ADMISSION WISE TUITION FEE</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->atform->render(); ?>
</table>
</fieldset>
<?php echo $this->atform->render_hidden(); ?>
</form>
<div class='dialog-alert'><div>Please specify student number.</div></div>