
<h1>Write Your comment Here</h1>
<?php $this->tpl->load_element('flash_message'); ?>
<form action="<?php echo site_url($active_module.'/post_comment'); ?>" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Your comment</b></td>
		<td>
			<div><textarea class="textfield" name="comment" type="texarea" required="required" style="width:300px;height:100px;" rows="12" cols="19"></textarea></div>
			<div>
				<input type="submit" class="button" value="publish"/>
				<input type="reset" class="button" value="Reset"/>
			</div>	
		</td>
	</tr>
</table>
</form>
<div id="comment">
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL.No.</b></th>
		<th width="35%" align="center"><b>Comment</b></th>
		<th width="10%" align="center"><b>Comment Date</b></th>
	</tr>
	<?php if($all_comment): ?>
	<?php 
	$i=1;
	foreach($all_comment as $note):
	?>
	<tr>
		<td align="center"><?php echo $i; ?></td>
		<td><?php echo $note['comment']; ?></td>	
		<td><?php echo $note['comment_date']; ?></td>	
			
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='4'>No Comment or Reply List found.</td>		
	</tr>
        <?php endif ?>
</table>
</div>

