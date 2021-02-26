<form id="frmParent" action="<?php echo site_url($active_module.'/save');?>" method="post">
<?php  $this->load->view('student/guardian_form.php') ?>
<div align="center"><input id="button1" type="submit" value=Save tabindex='9' /> <input
	id="button2" type="reset" tabindex='10' /></div>
	<input type='hidden' value='<?php echo $student_id ?>' name='student_id' />
	<input type='hidden' value='<?php echo $id ?>' name='id' />
</form>