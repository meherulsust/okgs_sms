<form id="frmParent" action="<?php echo site_url($active_module.'/save');?>" method="post">
<?php  $this->load->view('student/parents_form.php') ?>
<div align="center"><input id="button1" type="submit" value=Save tabindex='9' /> <input
	id="button2" type="reset" tabindex='10' /></div>
	<input type='hidden' id='dob' name='dob' />
</form>
<?php printr($mother)?>
<script type='text/javascript'><!--
$(document).ready(function(){
	 $('#frmParent').submit(  
	 function(){
		  $("#mtab").mask("Saving...",10);
		  return false;
		  });
	
});
	 
   
--></script>