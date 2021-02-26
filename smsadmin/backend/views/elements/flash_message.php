<?php if($this->input->is_ajax_request()): ?>
	<div id='ajax-flash'></div>
<?php endif?>
<ul class="system_messages">
<?php if($msg = $this->session->flashdata('success')):?>
<li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
<?php endif ?>
<?php if($msg = $this->session->flashdata('error')):?>
	<li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
<?php endif ?>
<?php if($msg = $this->session->flashdata('notice')):?>
	<li class="blue"><span class="ico"></span><strong class="system_title"> <?php echo $msg ?> </strong></li>	
<?php endif ?>
<?php if($msg = $this->session->flashdata('warning')):?>
	<li class="yellow"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
<?php endif ?>
<?php if($msg = $this->session->flashdata('info')):?>
	<li class="white"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
<?php endif ?>
</ul>
