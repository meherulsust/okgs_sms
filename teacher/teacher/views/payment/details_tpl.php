<style type="text/css">
.receipt_head tr{
	border:1px solid #ddd;
}
.receipt_head tr td{
	padding:2px 4px;
}
.receipt_body tr td{
	border:1px solid #ddd;
	padding:2px 6px;
}
</style>

<h1>New Payment</h1>		
	<h6 align="center"><img src="<?php echo base_url().'smsadmin/uploads/logo/'.$logo_file;?>" style="width:80px;"/></h6>
	<h4 align="center"><?php echo strtoupper($school_info['name']); ?></h4>
	<h6 align="center"><?php echo strtoupper($school_info['address1']);  ?></h6>
	<h6 align="center"><?php echo strtoupper($school_info['address2']);  ?></h6>
	
	<table width="80%" align="center" class="receipt_head">		
		<tr>
                    <td colspan="2">&nbsp;</td>
			<td align="right">Date :</td>
			<td><?php echo $current_date; ?></td>	
		</tr>	
		<tr>
			<td>Student's Name</td>
			<td colspan="4">: <?php echo $first_name.' '.$last_name; ?></td>					
		</tr>
		<tr>
			<td>Student Number </td>
			<td>: <?php echo $student_number;?></td>
			<td align="right">Class Roll :</td>
			<td><?php echo $class_roll;?></td>
		</tr>
		<tr>
			<td width="25%">Class</td>
			<td width="25%">: <?php echo $class;?></td>
			<td width="25%" align="right">Form :</td>
			<td width="25%"><?php echo $section;?></td>
		</tr>
	</table>	
	</br>
	<table width="80%" align="center" class="receipt_body">		
		<tr>
			<td width="5%" align="center"><b>SL.</b></td>
			<td width="60%" align="center"><b>Name of Head</b></td>
			<td width="25%" align="center"><b>Amount</b></td>
		</tr>	
		<?php
		if(!empty($tuition_fees)):
			$i=1;			
			foreach($tuition_fees as $val):			
		?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $val['title'];?></td>
				<td align="right"><?php echo $val['ammount'];?></td>
			</tr>		
		<?php
			$i++;
                    endforeach;
		?>	
		<tr>
			<td colspan="2" align="right"><b>Total Amount :</b></td>
			<td align="right"><b><?php echo $total_amount; ?></b></td>
		</tr>
		<?php endif;	?>
	</table>
	<?php 
	if($payment_info['pay_status']=='UNPAID')
	{
	?>
		<form action="<?php echo site_url('payment/submit_payment') ?>" method="post" name="payment">
			<h6 align="center"><input  class="button" type="submit" value="Submit Payment"/></h6>
		</form>
	<?php 
	}
	?>
	<br/>