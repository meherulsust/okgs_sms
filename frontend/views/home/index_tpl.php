<div style="float:left;width:48%">
    <h1>General Notice</h1>
	<?php 
	if($general_notice){ 
	$i=0;
	foreach($general_notice as $val){ 
	?>
		<span class="notice_title"><?php echo $val['notice_title'];?></span></br>
		<span class="notice_date">Date : <?php echo $val['created_at'];?></span></br>
		<span class="full_notice"><?php echo $val['full_notice'];?></span>
		<div id="notice_border"></div>
	<?php
		$i++;
	} 
	if($i==15){
	?>
		<a href="<?php echo site_url().'/home/all_notice';?>" class="notice_title">Show All</a>
	<?php
	}
	}else{ 
	?>
		<p>No notice</p>
	<?php } ?>
</div>
<div style="float:right;width:48%">
    <h1>Personal Notice</h1>
	<?php 
	if($personal_notice){ 
	foreach($personal_notice as $val){ 
	?>
		<span class="notice_title"><?php echo $val['notice_title'];?></span></br>
		<span class="notice_date">Date : <?php echo $val['created_at'];?></span></br>
		<span class="full_notice"><?php echo $val['full_notice'];?></span>
		<div id="notice_border"></div>
	<?php 
	} 
	if($i==15){
	?>
		<a href="<?php echo site_url().'/home/all_notice/'.$class_id;?>" class="notice_title">Show All</a>
	<?php
	}
	}else{ 
	?>
		<p>No notice</p>
	<?php } ?>
</div>
