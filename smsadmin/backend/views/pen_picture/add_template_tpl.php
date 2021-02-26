<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 id="add"> Add Pen Picture Template</h3>
<form name='frm-pen-picture-template' id='frm-pen-picture-template' method='post' action='<?php echo site_url($active_module.'/save_template')?>'>
<fieldset id="config_exam_classes"><legend>Add Pen Picture Template</legend>
    <table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->add_templateform->render(); ?>
    </table>
</fieldset>
</form>
</div>