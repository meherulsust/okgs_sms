<form id="frmStdAjax" action="<?php echo site_url($active_module.'/save_more');?>" method="post">
<?php $this->load->view('student/personal_info_form.php'); ?>
<div align="center">
<input class="btn" type="submit" value=Save tabindex='9' />
<input class="btn" type="reset" tabindex='10' /> 
<input class="btn" type="button" tabindex='11' value='Cancel' id='lnk-cancel'/> 
</div>
	<input type='hidden' name='actn' value='details' />
	<input type='hidden' name='cancel_url' id='cancel_url'  value='<?php echo site_url('student/personal/type/personal/std_id/'.$std_id.'/id/'.$id.'/actn/')?>'/>
</form>
