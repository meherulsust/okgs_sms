<?php 
$this->tpl->set_css('jquery.multiselect');
$this->tpl->set_js(array('jquery.validate','jquery.multiselect','exam_registration_form'));
?>
<form name='frm-regi' id='frm-regi' method='post' action='<?php echo site_url($active_module.'/saveregi/'.$exam_id)?>' >
<fieldset id="personal"><legend>REGISTRATION INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->regiform->render(); ?>
</table>
</fieldset>
<?php echo $this->regiform->render_hidden(); ?>
</form>