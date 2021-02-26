<div id="box">
    <h3 id="add"> <?php if($this->test_entry_form->is_new()): ?> Test Entry Form<?php else: ?> 
        Edit Test Entry Form
        <?php endif; ?>
    </h3>
    <?php $this->load->view('publish_result/test_entry_form'); ?>
</div>