<form name='frm-exam' id='frm-exam' method='post' action='<?php echo site_url($active_module.'/typesave')?>' >
<fieldset id="personal"><legend>LOOKUP CATEGORY INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->ltform->render(); ?>
</table>
</fieldset>
<?php echo $this->ltform->render_hidden(); ?>
</form>
<script type="text/javascript">
$('#cancel-btn').click(function(){
    location.href = "<?php echo site_url('lookup/index') ?>"; 
});
</script>