<?php $this->tpl->set_js('photo_form');?>
<form name='frm-img' id='frm-img' method='post' action='<?php echo site_url($active_module.'/upload/'.$id); ?>' enctype="multipart/form-data" >
<fieldset id="personal"><legend>UPLOAD PHOTO</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->pform->render(); ?>
</table>
</fieldset>
<?php echo $this->pform->render_hidden(); ?>
</form>