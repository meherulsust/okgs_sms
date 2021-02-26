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
    <h3 class='grid_title_bar'>Student Information</h3>
<form name='frm-studentinfo' id='frm-studentinfo' method='post' action='<?php echo site_url($active_module.'/student_information'); ?>' >
    <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <?php echo $this->student_infoform->render();  ?>
    </table>
</form>
    
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#stdinfo_class_id').selectChain({            
	    target: $('#stdinfo_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'stdinfo_class_id'}
	});
    });
</script>