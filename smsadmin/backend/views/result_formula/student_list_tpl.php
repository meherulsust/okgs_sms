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
    <h3 class='grid_title_bar'>Remove Result</h3>
<form name='frm-view-result' id='frm-view-result' method='post' action='<?php echo site_url($active_module.'/student_list'); ?>' >
    <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <?php echo $this->generate_grid_boardform->render();  ?>
    </table>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#generate_grid_boardform_class_id').selectChain({            
	    target: $('#generate_grid_boardform_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'generate_grid_boardform_class_id'}
	});
    });
</script>

