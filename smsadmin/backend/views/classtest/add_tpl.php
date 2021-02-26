<div id="box">
<h3><?php if($this->ctform->is_new()) echo "Create class test"; else echo "Edit class test"; ?></h3>
<div id='new-classtest'>
<?php $this->load->view('classtest/classtest_form') ?>
</div>
</div>