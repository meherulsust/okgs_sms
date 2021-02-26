<?php $this->tpl->load_element('flash_message'); ?>
<div id="box">
    <h3 id="add"> <?php if($this->studenthouseform->is_new()): ?> Create Student <?php else: ?>
        Edit Student
        <?php endif; ?>
    </h3>
<?php $this->load->view('student_house/student_house_form') ?>
</div>



