<?php 
	$this->tpl->set_jquery_ui(array('datepicker'));
	echo $this->tpl->load_element('flash_message'); 
?>
<div class="box">
    <h3>Search Student Attendance</h3>
    <form method="post" action="<?php echo site_url($active_module.'/filter') ?>" >
		<table class="frm-tbl" cellpadding="0" cellspacing="0" border="0">
			<?php echo $this->attf->render() ?>
		</table>
    </form>
</div>
<br>
<?php $this->tpl->load_element('grid_board');?>
<script language="javascript">
    $(document).ready(function(){
        $('#attfilter_class_id').selectChain({
			target: $('#attfilter_section_id'),
			value:'title',
			url: SITE_URL+'json/admission_section',
			type: 'post',
			data:{'admission_class_id': 'attfilter_class_id' }
		});    
		
		$("#attfilter_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "-02:+01",
			dateFormat: 'yy-mm-dd'
		});
    });
</script>