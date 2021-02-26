<?php $this->tpl->load_element('flash_message'); ?>
<div id="box">
    <h3 id="add"> <?php if($this->housetransferform->is_new()): ?> Student House Transfer<?php else: ?>
        Edit Student
        <?php endif; ?>
    </h3>
<?php $this->load->view('student_house/house_transfer_form') ?>
</div>



