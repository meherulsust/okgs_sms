<div id="box">
<h3 id="addbook"><?php if($this->lform->is_new()): ?>Add lookup item <?php else: ?>Edit lookup item <?php endif ?></h3>
<div id='cat-add'>
<?php $this->load->view('lookup/lookup_form') ?>
</div>
</div>