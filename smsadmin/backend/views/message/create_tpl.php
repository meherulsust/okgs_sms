<div id="box">
    <h3 id="add"> <?php if($this->messageform->is_new()): ?> Create Message <?php else: ?>
        Edit Message
        <?php endif; ?>
    </h3>
<?php $this->load->view('message/message_form') ?>
</div>



