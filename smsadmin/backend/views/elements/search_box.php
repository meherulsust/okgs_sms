<div class="table">
	<img src="<?php echo $image_url ?>bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo $image_url ?>bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<form action='<?php echo site_url($active_module.'/search') ?>' name='grid_search' method='post'>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="5">Search Center</th>
		</tr>									
		<tr>
			<td><strong>Center Name:</strong> </td>
			<td><input type="text" name="cname" value='<?php echo @$grid_filter['cname'] ?>' /></td>
			<td><strong>Address:</strong> </td>
			<td><input type="text" name="address"  value='<?php echo @$grid_filter['address'] ?>'  /></td>
			<td><input type="image" src="<?php echo $image_url ?>button-sn.gif"  /></td>										
		</tr>
	</table>	
	</form>							
</div>	