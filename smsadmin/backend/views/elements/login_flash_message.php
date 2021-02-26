<?php if($msg = $this->session->flashdata('error_msg')):?>
    <div class='error' style="text-align:center"><?php echo $msg ?></div>
 <?php endif?>   