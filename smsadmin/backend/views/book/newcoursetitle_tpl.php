<div id="box">
<h3><?php if($this->ctform->is_new()) echo 'Create course title'; else echo 'Edit course title';  ?></h3>
<div>
<?php $this->load->view('book/course_title_form') ?>
</div>
</div>