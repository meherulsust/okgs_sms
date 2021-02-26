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
	
	<h4 align="center">MILITARY INSTITUTE OF SCIENCE AND TECHNOLOGY</h4>
	<h6 align="center">MIRPUR CANTONMENT</h6>
	<h6 align="center">DHAKA - 1216</h6>
	
	<table width="80%" align="center" class="receipt_head">		
		<tr>
			<td>A/C No.</td>
			<td>: 12569854200156</td>
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
			$add_amount=0;
			$deduct_amount=0;
			foreach($tuition_fees as $val):
			if($val['head_type']=='COST')
			{
				$add_amount=$add_amount+$val['amount'];
			}
			if($val['head_type']=='WAIVER')
			{
				$deduct_amount=$deduct_amount+$val['amount'];
			}	
			
			$total_amount=$add_amount-$deduct_amount;
			
		?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $val['title'];?></td>
				<td align="right"><?php echo sprintf('%0.2f',$val['amount']);?></td>
			</tr>		
		<?php
			$i++;
                    endforeach;
		?>	
		<tr>
			<td colspan="2" align="right"><b>Total Amount :</b></td>
			<td align="right"><b><?php echo sprintf('%0.2f',$total_amount) ?></b></td>
		</tr>
		<?php endif;	?>
	</table>
	
	<h6 align="center"><input  class="button" type="submit" value="Submit Payment"/></h6>
	