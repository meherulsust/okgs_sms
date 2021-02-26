<h1>Payment List</h1>
<?php echo $this->session->flashdata('message');?>

<table width="80%" align="center" class="list_table">
     
	<tr>
		<th width="5%" align="center"><b>SL.</b></th>
		<th width="30%" align="center"><b>Payment Title</b></th>
		<th width="18%" align="center"><b>Transaction ID</b></th>
		<th width="10%" align="center"><b>Amount</b></th>
		<th width="10%" align="center"><b>Month</b></th>
        <th width="7%" align="center"><b>Year</b></th>
		<th width="13%" align="center"><b>Expire Date</b></th>
		<th width="9%" align="center"><b>Status</b></th>
		<th align="center"><b>&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;</b></th>
	</tr>
        <?php if($fees): ?>
        <?php 
		$i=1;
		foreach($fees as $fee):
		if($current_date >= $fee['start_date'])
		{
			if($fee['payment_generate_type']==1)
			{
				$type = '(Advance)';
			}elseif($fee['payment_generate_type']==2)
			{
				$type = '(Partial)';
			}else{
				$type = '';
			}
		
		?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td>Monthly Fee</td>	
		<td><?php echo $fee['bank_transection_id'];?></td>
		<td align="center"><?php echo $fee['ammount'];?></td>		
        <td align="center"><?php echo date("F", mktime(0, 0, 0, $fee['month'], 10)).$type;?> </td>
		<td align="center"><?php echo $fee['year'];?> </td>
		<td align="center"><?php echo $fee['expire_date'];?> </td>
		<td align="center"><?php echo $fee['pay_status'];?> </td>
		<td align="center">
             <a href="<?php echo site_url('payment/details/'.$fee['id']) ?>" class="icon_view" title="View">&nbsp;</a>
	         <a href="<?php echo site_url('payment/download/'.$fee['id']) ?>" class="icon_download" title="Download"></a>
		</td>
	</tr>
        <?php 
			$i++;
		}
		endforeach; 
		?>
        <?php else: ?>
	<tr>
		<td align="center" colspan='8'>No payment request is found.</td>	
		
	</tr>
        <?php endif; ?>
</table>
