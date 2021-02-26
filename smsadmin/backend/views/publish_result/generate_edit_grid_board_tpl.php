<?php $this->tpl->set_js('select-chain');?>
<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 class='grid_title_bar'>Update Result</h3>
<form name='frm-generate-edit-grid-board' id='frm-generate-edit-grid-board' method='post' action='<?php echo site_url($active_module.'/generate_edit_grid_board'); ?>' >
    <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <?php echo $this->generate_edit_grid_boardform->render();  ?>
    </table>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#generate_edit_grid_boardform_class_id').selectChain({            
	    target: $('#generate_edit_grid_boardform_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'generate_edit_grid_boardform_class_id'}
	});
    });
</script>
<script>
$(document).ready(function(){
    $('#generate_edit_grid_boardform_class_id').change(function(e){
        var class_id = $("#generate_edit_grid_boardform_class_id").val();
        $("#generate_edit_grid_boardform_subject_id").find("option:gt(0)").remove();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/publish_result/get_related_subjects',
            dataType:'json',
            type: "post",
            data: {class_id: class_id},
            success: function(data){
                $.each(data,function(i,v){
                    $("#generate_edit_grid_boardform_subject_id").append('<option value="'+ v.id +'">'+ v.title +'</option>');
                });
            }
        });  
    });
});
</script> 