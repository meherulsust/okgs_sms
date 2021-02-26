<?php $this->tpl->set_js('personal_info_form');?>
<?php $this->tpl->load_element('flash_message');?>
<form  id="frm-personal-info" name='<?php echo $this->piform->get_name() ?>' method='POST' action='<?php
if($this->input->is_ajax_request()) echo site_url($active_module.'/pisave'); else echo site_url($active_module.'/save') ?>' >
<fieldset id="personal"><legend>PERSONAL INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->piform->render(); ?>
</table>
</fieldset>
	<?php echo $this->piform->render_hidden(); ?>
	<input type='hidden' id='datepicker' />
</form>