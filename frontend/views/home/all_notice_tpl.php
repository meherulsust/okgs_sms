<div style="float:left;width:100%">
    <h1><?php echo $head;?></h1>
	<?php 
	if($notice){ 
	foreach($notice as $val){ 
	?>
		<span class="notice_title"><?php echo $val['notice_title'];?></span></br>
		<span class="notice_date">Date : <?php echo $val['created_at'];?></span></br>
		<span class="full_notice"><?php echo $val['full_notice'];?></span>
		<div id="notice_border"></div>
	<?php 
	} 	
	}else{ 
	?>
		<p>No notice</p>
	<?php } ?>
</div>

