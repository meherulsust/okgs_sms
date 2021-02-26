<div id="box">
<h3><?php if($this->cform->is_new()) echo 'Reply'; else echo 'Reply';  ?></h3>
<div>
<?php $this->load->view('comment/comment_list_form') ?>
</div>
</div>