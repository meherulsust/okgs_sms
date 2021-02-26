<div id="box">
    <h3 id="add"> <?php if($this->houseform->is_new()): ?> Create House <?php else: ?>
        Edit House
        <?php endif; ?>
    </h3>
<?php $this->load->view('house/house_form') ?>
</div>



