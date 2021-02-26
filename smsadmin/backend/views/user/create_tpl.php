<div id="box">
    <h3 id="add"> <?php if($this->userform->is_new()): ?> Create User <?php else: ?>
        Edit User
        <?php endif; ?>
    </h3>
<?php $this->load->view('user/user_form') ?>
</div>



