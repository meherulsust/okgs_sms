<div id="box">
<h3 id="adduser">Add Student</h3>
<form id="frmStdCreate" action="<?php echo site_url($active_module.'/save');?>" method="post">
<?php $this->load->view('student/personal_info_form');?>
<div align="center"><input id="button1" type="submit" value=Save tabindex='9' /> <input
	id="button2" type="reset" tabindex='10' /></div>
</form>

</div>