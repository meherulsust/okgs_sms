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
<span>Total Records : <?php echo $total_student; ?></span><br/>

<table border="1" width="100%" id="report">		
	<tr>
		<td align="center" rowspan="2"><b>SL. No.</b></td>
		<td align="center" rowspan="2"><b>Student Name</b></td>
		<td align="center" rowspan="2"><b>Student Number</b></td>
		<td align="center" rowspan="2"><b>Class</b></td>
		<td align="center" rowspan="2"><b>Form</b></td>
		<td align="center" rowspan="2"><b>Class Roll</b></td>	
		<td align="center" rowspan="2"><b>House</b></td>
		<td align="center" rowspan="2"><b>Payment Status</b></td>
		<td align="center" rowspan="2"><b>Payment Date</b></td>
		<td align="center" colspan="<?=sizeof($head_info)+1;?>"><b>Fee</b></td>		
	</tr>
	<tr>
		<?php 
		foreach($head_info as $head){	?>
		<td class="head"><div class="text"><?php echo $head['title']; ?></div></td>
		<?php }	?>
		<td align="center"><b>Total</b></td>
		<td align="center"><b>Remarks</b></td>
		<td align="center"><b>Grand Total</b></td>
	</tr>
	<?php 
	$str = 'a';
	$sub_str = 'a';
	$grand_total = 0;
	foreach($class_list as $class){	
				
		$total_amount=0;
		$serial_no=1;
		foreach($report_list as $report){ 
		if($class['id']==$report['class_id'])
		{	
	?>
	<tr>
		<td align="center"><b><?php echo $serial_no; ?></b></td>
		<td><?php echo $report['student_name']; ?></td>
		<td><?php echo $report['student_number']; ?></td>
		<td><?php echo $report['class']; ?></td>
		<td><?php echo $report['section']; ?></td>
		<td align="center"><?php echo $report['class_roll']; ?></td>
		<td><?php echo $report['house_name']; ?></td>
		<td><?php echo $report['pay_status']; ?></td>
		<td align="left"><?php echo $report['payment_date']; ?></td>	
		<?php 
			$total_head_amount=0.00;
			foreach($head_info as $head){	
		?>
		<td style="mso-number-format:'\@';">
		<?php 		
			
			foreach($report['head'] as $heads){
				if($heads['head_id']==$head['head_id']){
					echo $heads['amount'];
					$total_head_amount=$total_head_amount+$heads['amount'];
					if ( ! isset($subtotal[$class['id']][$head['head_id']])) {
					   $subtotal[$class['id']][$head['head_id']] = null;
					}
					
					$subtotal[$class['id']][$head['head_id']] = $subtotal[$class['id']][$head['head_id']]+$heads['amount'];
				}
			}
		?>
		</td>
		<?php }	?>
		<td align="right" style="mso-number-format:'\@';">
		<?php 
			echo sprintf("%.2f",$total_head_amount); 
			$total_amount=$total_amount+$total_head_amount;	
		?>
		</td>
		<td>
		<?php
		if($report['payment_generate_type']==1){
			echo 'Advance Payment ('.$report['month'].')';
		}elseif($report['payment_generate_type']==2){
			echo 'Partial Payment ('.$report['month'].')';
		}else{
			echo '';
		}
		?>
		</td>
	</tr>	
	<?php	
		$serial_no++;
	}
	}
	?>	
	
	<tr>
		<td align="right" colspan="9"><b>Head wise Total = </b></td>
		<?php 
		
		foreach($head_info as $head){
		?>
		<td style="mso-number-format:'\@';">
		<?php 	
			if ( ! isset($subtotal[$class['id']][$head['head_id']])) {
			   $subtotal[$class['id']][$head['head_id']] = null;
			}
			echo sprintf("%.2f",$subtotal[$class['id']][$head['head_id']]); 			
		?>
		</td>
		<?php }	?>
		<td></td>		
	</tr>
	
	<tr>
		<td align="center" colspan="<?=sizeof($head_info)+10;?>">			
			<?php 
				$sub_str = $sub_str.'+'.$str;
			?>
			<b><?php echo $str++;?>. Sub Total ( <?php echo $class['title'];?> ) </b>
			
		</td>
		<td></td>
		<td align="right" style="mso-number-format:'\@';">
			<?php $grand_total = $grand_total + $total_amount; ?>
			<b><?php echo sprintf("%.2f",$total_amount);  ?></b>
		</td>		
	</tr>
	<?php
	}
	?>
	<tr height="50">
		<td valign="bottom" align="center" colspan="<?=sizeof($head_info)+10;?>">		
			<b>Grand Total ( <?php echo $sub_str;?> ) = </b>
		</td>
		<td></td>
		<td valign="bottom" align="right" style="mso-number-format:'\@';"><b><?php echo sprintf("%.2f",$grand_total);  ?></b></td>		
	</tr>
	<tr height="100">
		<td valign="bottom" align="center" colspan="<?=sizeof($head_info)+12;?>">		
			Accountant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Admin Officer (Act.)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vice Principal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Principal
		</td>		
	</tr>
</table>
