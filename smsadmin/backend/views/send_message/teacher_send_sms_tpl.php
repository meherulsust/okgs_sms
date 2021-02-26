<div id="box">
    <h3 id="add"> <?php if($this->sendteachermessageform->is_new()): ?> Create Message <?php else: ?>
        Edit Message
        <?php endif; ?>
    </h3>
<?php $this->load->view('send_message/send_teacher_message_form') ?>
</div>



