<?php $this->tpl->load_element('flash_message');?>
<div id="box">
    <h3 id="adduser">Edit Extra Class</h3>
    <form id="frm-assign-extra-class" name="frm-assign-extra-class" method="post" action="<?php echo site_url($active_module.'/new_extra_class'); ?>">
        <fieldset id="extra_class">
            <table cellpadding="0" cellspacing ="0" border="0" class="frm-tbl">
                <?php echo $this->secform->render();  ?>
            </table>
        </fieldset>
        <?php echo $this->secform-> render_hidden(); ?>	
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#extraclass_class_date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });   

        $('#extraclass_class_id').selectChain({
            target: $('#extraclass_section_id'),
            value:'title',
            url: SITE_URL+'/json/section',
            type: 'post',
                data:{class_id: 'extraclass_class_id'}
        });
	
	$('#extraclass_class_id').selectChain({
	    target: $('#extraclass_class_time_id'),
	    value:'title',
	    url: SITE_URL+'/json/class_time',
	    type: 'post',
		data:{class_id: 'extraclass_class_id'}
	});
    
    });
</script>