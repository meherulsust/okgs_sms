<script>
$(document).ready(function(){       
	$(".delete").click(function(){
		if (!confirm("Do you want to delete?")){
			return false;
		}
	});   
 });
</script>
<?php $this->tpl->load_element('flash_message');?>
<div id="box">
	<h3 id="addbook">Delete Tuition Fee</h3>
	<div id='book-create'>
		<form name='frm-tf-form' id='frm-book' method='post' action='<?php echo site_url($active_module.'/delete_tuition_fee')?>' >
		<fieldset id="personal"><legend>DELETE TUITION FEE</legend>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->tfdform->render(); ?>
		</table>
		</fieldset>
		<?php echo $this->tfdform->render_hidden(); ?>
		</form>
	</div>
</div>