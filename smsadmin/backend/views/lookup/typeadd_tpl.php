<div id="box">
<h3 id="addbook"><?php if($this->ltform->is_new()): ?>Add lookup category <?php else: ?>Edit lookup type <?php endif ?></h3>
<div id='cat-add'>
<?php $this->load->view('lookup/lookup_type_form') ?>
</div>
</div>