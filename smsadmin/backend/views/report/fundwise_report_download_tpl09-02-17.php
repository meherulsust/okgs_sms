<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$report_file_name);
	header("Pragma: no-cache");
	header("Expires: 0"); 	
?>
<style>
.text{
	text-align: center;
	vertical-align: bottom;
	width: 20px;
	margin: 0px;
	padding: 0px;
	padding-left: 3px;
	padding-right: 3px;
	padding-top: 10px;
	white-space: nowrap;
	
	-webkit-transform: rotate(-90deg);
	-moz-transform: rotate(-90deg);
	-ms-transform: rotate(-90deg);
	-o-transform: rotate(-90deg);
	transform: rotate(-90deg);
	mso-rotate: 90;
	-webkit-transform-origin: 50% 50%;
	-moz-transform-origin: 50% 50%;
	-ms-transform-origin: 50% 50%;
	-o-transform-origin: 50% 50%;
	transform-origin: 50% 50%;
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);		
}
</style>
<h2><?php echo $school_info['name'];?></h2>
<span>Financail Report</span><br/>
<span><?php echo $report_title; ?></span><br/>

<table border="1" width="100%" id="report">		
	<tr>
		<td align="center"><b>Fund</b></td>
		<?php 
		
		foreach($fund_list as $fund){				
			$i=0;
			foreach($head_info as $head){
				if($fund['id']==$head['fund_id'])
				{
					$i++;	
				}
			}			
		?>
		<td align="center" style="background:Green" colspan="<?php echo $i; ?>"><?php echo $fund['title']; ?></td>
		<td></td>	
		<?php }	?>
		<td></td>	
	</tr>
	<tr>
		<td align="center"><b>Payment Date</b></td>
		<?php 
		$subtotal_no=1;
		foreach($fund_list as $funds){	
			$j=0;
			foreach($head_info as $head){
				if($funds['id']==$head['fund_id'])
				{
					$j++;	
		?>
					<td class="head"><div class="text"><?php echo $head['title']; ?></div></td>				
		<?php 
				}
			}
			if($j==0){
				echo '<td></td>';
			}	
		?>
		<td class="head"><div class="text"><b><?php echo $subtotal_no; ?>. Sub Total</b></div></td>
		<?php	
			$subtotal_no++;
		}
		?>	
		<td class="head"><div class="text"><b><?php echo $subtotal_no; ?>. Grand Total</b></div></td>	
	</tr>
	
	<?php 
	$new_month = str_pad($month,2,"0",STR_PAD_LEFT);
	$timestamp = mktime(0,0,0,$new_month,1,$year);
	$maxday = date("t",$timestamp);
	$data_result = array();
	$final_sum_grand_total = 0;
	for($i=1;$i<=$maxday;$i++)
	{
	
	$month_date = $year.'-'.$new_month.'-'.str_pad($i,2,"0",STR_PAD_LEFT);
	
	$grand_total = 0.00;	
	$sum_grand_total = 0.00;	
	$total_amount=0.00;
	$serial_no=1;
	$count = 0;
	foreach($report_list as $report){ 
		$payment_date = date('Y-m-d',strtotime($report['payment_date']));
		if($payment_date==$month_date){	
	?>
	
		<?php 
		$grand_total = 0.00;
		foreach($fund_list as $funds){	
			$k=0;
			$fundwise_total = 0.00;
			foreach($head_info as $head){
				if($funds['id']==$head['fund_id'])
				{
					$head_amount ='0.00';
					foreach($report['head'] as $heads){
						if($heads['head_id']==$head['head_id']){
							$head_amount =$heads['amount'];
							$fundwise_total = $fundwise_total +	$heads['amount'];								
							if(!isset($subtotal[$funds['id']][$head['head_id']]) AND $fund_subtotal[$funds['id']][$head['head_id']]){
								$subtotal[$funds['id']][$head['head_id']] = null;
								$fund_subtotal[$funds['id']][$head['head_id']]=null;
							}else					
								$subtotal[$funds['id']][$head['head_id']] = $subtotal[$funds['id']][$head['head_id']]+$heads['amount'];
								$fund_subtotal[$funds['id']][$head['head_id']] = $fund_subtotal[$funds['id']][$head['head_id']]+$heads['amount'];
							
		
						}
					}
					$k++;
					?>
	
		<?php 
					
				}
			}
			if($k==0){
		?>
			
		<?php
			}	
		?>
		
		<?php 		
			if(!isset($sum_subtotal[$funds['id']][$head['head_id']]) AND $sum_fund_subtotal[$funds['id']][$head['head_id']]){
				$sum_subtotal[$funds['id']][$head['head_id']] = null;
				$sum_fund_subtotal[$funds['id']][$head['head_id']]=null;
			}else					
				$sum_subtotal[$funds['id']][$head['head_id']] = $sum_subtotal[$funds['id']][$head['head_id']]+$fundwise_total;
				$sum_fund_subtotal[$funds['id']][$head['head_id']] = $sum_fund_subtotal[$funds['id']][$head['head_id']]+$fundwise_total;
		?>
		<?php		
			$grand_total = $grand_total + $fundwise_total;
		}
		?>
		
		
	</tr>	
	<?php	
		$sum_grand_total = $sum_grand_total + $grand_total;
	
		$serial_no++;
		$count++;
		}
	}
	
	if($count>0)
	{
		$final_sum_grand_total = $final_sum_grand_total + $sum_grand_total;
	
	?>	
	<tr>
		<td align="right" colspan="1"><?php echo $month_date; ?></td>
		
		<?php 
		foreach($fund_list as $funds){	
			$n=0;
			foreach($head_info as $head){
				if($funds['id']==$head['fund_id'])
				{
					if(!isset($subtotal[$funds['id']][$head['head_id']])){
						$subtotal[$funds['id']][$head['head_id']] = null;
						
					}	
		?>
					<td align="right" style="mso-number-format:'\@';"><?php echo sprintf("%.2f",$subtotal[$funds['id']][$head['head_id']]); ?>
					<?php $subtotal[$funds['id']][$head['head_id']]= 0; ?> <!--added by Md.Meherul Islam-->
		<?php						
					$n++;
				}
		?>
			
		<?php 				
			}	
			if($n==0){
		?>
			<td  align="right" style="mso-number-format:'\@';">0.00</td>
		<?php					
			}	
		?>
			<td  align="right" style="mso-number-format:'\@';"><b><?php echo sprintf("%.2f",$sum_subtotal[$funds['id']][$head['head_id']]);?></b></td>
			<?php $sum_subtotal[$funds['id']][$head['head_id']] =0; ?> <!--added by Md.Meherul Islam-->
		<?php
			
		}
		?>			
		<td  align="right" style="mso-number-format:'\@';"><b><?php echo sprintf("%.2f",$sum_grand_total); ?></b></td>	
	</tr>
	<?php 
		}
	}
	?>
	<tr>
		<td align="right" style="background:Green"><b>Fund wise Total = </b></td>
		<?php
		foreach($fund_list as $funds){	
			$n=0;
			foreach($head_info as $head){
				if($funds['id']==$head['fund_id'])
				{
					if(!isset($subtotal[$funds['id']][$head['head_id']])){
						$subtotal[$funds['id']][$head['head_id']] = null;
						
					}	
		?>
					<td align="right" style="mso-number-format:'\@';background:yellow"><?php echo sprintf("%.2f",$fund_subtotal[$funds['id']][$head['head_id']]); ?>
		<?php						
					$n++;
				}
		?>
			
		<?php 				
			}	
			if($n==0){
		?>
			<td  align="right" style="mso-number-format:'\@';">0.00</td>
		<?php					
			}	
		?>
			<td  align="right" style="mso-number-format:'\@';background:yellow"><b><?php echo sprintf("%.2f",$sum_fund_subtotal[$funds['id']][$head['head_id']]);?></b></td>
		<?php
			
		}
		?>
	</tr>
	<tr>
		<td align="right" style="mso-number-format:'\@';" colspan="<?=sizeof($head_info)+16;?>">		
			<b>Final Total = <?php echo sprintf("%.2f",$final_sum_grand_total); ?></b>
		</td>		
	</tr>
	<tr height="100">
		<td valign="bottom" align="center" colspan="<?php echo (sizeof($fund_list)*2)+sizeof($head_info)-2;?>">		
			Accountant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin Officer (Act.)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vice Principal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Principal
		</td>		
	</tr>
	
</table>