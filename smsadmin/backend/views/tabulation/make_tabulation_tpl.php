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
    <h3 id="add">Generate Tabulation Sheet</h3>
    <fieldset id="config_exam_classes"><legend>Tabulation Sheet</legend>
        <form name='frm-make-tabulation' id='frm-make-tabulation' method='post' action='<?php echo site_url($active_module.'/make_tabulation')?>' >
            <table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
            <?php echo $this->tabulationform->render(); ?>
            </table>
        </form>
    </fieldset>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#tabulation_class_id').selectChain({            
	    target: $('#tabulation_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'tabulation_class_id'}
	});
    });
</script>

