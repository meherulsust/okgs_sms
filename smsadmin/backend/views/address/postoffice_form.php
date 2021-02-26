<?php 
	$this->tpl->set_js(array('select-chain')); 
?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-postoffice" name='<?php echo $this->tform->get_name() ?>' method='POST' action='<?php echo site_url($active_module.'/save_postoffice') ?>' enctype='multipart/form-data' >
<fieldset id="personal"><legend>POST OFFICE INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->tform->render(); ?>
</table>
</fieldset>
	<?php echo $this->tform->render_hidden(); ?>
</form>

<script>
$(document).ready(function(){       
	$('#postof_district_id').selectChain({
		target: $('#postof_thana_id'),
	    value:'title',
	    url: SITE_URL+'/json/address_thana',
	    type: 'post',
		data:{district_id: 'postof_district_id'}
	});
 });
</script>