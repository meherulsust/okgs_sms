<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 id="add"> <?php if($this->config_exam_classform->is_new()): ?> Configure Exam for Classes<?php else: ?> 
        Edit Configure Exam for Classes
        <?php endif; ?>
    </h3>
    <?php $this->load->view('publish_result/config_exam_classform'); ?>
</div>

