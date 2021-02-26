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
		<td align="center" rowspan="2"><b>Payment Month</b></td>
		<td align="center" rowspan="2"><b>Payment Date</b></td>
		<td align="center" colspan="<?=sizeof($head_info)+1;?>"><b>Fee</b></td>
		<td align="center" rowspan="2"><b>Remarks</b></td>				
	</tr>
	<tr>
		<?php 
		foreach($head_info as $head){	?>
		<td class="head"><div class="text"><?php echo $head['title']; ?></div></td>
		<?php }	?>
		<td align="center"><b>Total</b></td>
	</tr>
	<?php 	
		$total_amount=0;
		$serial_no=1;
		foreach($report_list as $report){ 	
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
		<td><?php echo $report['month']; ?></td>
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
					if ( ! isset($subtotal[$head['head_id']])) {
					   $subtotal[$head['head_id']] = null;
					}
					
					$subtotal[$head['head_id']] = $subtotal[$head['head_id']]+$heads['amount'];
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
	?>
	<tr>
		<td align="right" colspan="10"><b>Head wise Total = </b></td>
		<?php 
		$sum_subtotal = 0.00;
		foreach($head_info as $head){
		?>
		<td style="mso-number-format:'\@';">
		<?php 		
			echo sprintf("%.2f",$subtotal[$head['head_id']]); 			
		?>
		</td>
		<?php }	?>
		<td align="right" style="mso-number-format:'\@';"></td>		
	</tr>
	<tr>
		<td align="right" colspan="<?=sizeof($head_info)+10;?>"><b>Total Amount = </b></td>
		<td align="right" style="mso-number-format:'\@';"><b><?php echo sprintf("%.2f",$total_amount);  ?></b></td>		
	</tr>
</table>

<!--
<table border="1" width="100%">
	<tr>
		<td rowspan="3" align="center" style="vertical-align:middle;"><b>Ledger</b></td>
		<td><b>Class :</b></td>
		<td><b><?php echo $class_info['title'];?></b></td>		
	</tr>
	<tr>
		<td><b>Form :</b></td>
		<td><b><?php echo $section_info['title'];?></b></td>
	</tr>
	<tr>
		<td>
			<div class="text"><b>Student Number</b></div>
			<div class="text"><b>Student Name</b></div>
		</td>
		<?php foreach($report_list as $val){ ?>
		<td>
			<table border="1">
			<tr>
				<td height="150">
					<div class="text"><?php echo $val['student_number']; ?></div>
				</td>				
			</tr>
			<tr>
				<td height="200">
					<div class="text"><?php echo $val['student_name']; ?></div>
				</td>				
			</tr>
			</table>	
		</td>
		<?php } ?>			
		<td align="center"><b>Total Amount</b></td>	
	</tr>
	<?php 	
	$total_amount=0;
	$serial_no=1;
	foreach($head_info as $head){ 
	?>
	<tr>
		<td><b><?php echo $serial_no.'. '.$head['title']; ?></b></td>
		<td></td>
		<?php 
		$total_head_amount=0;
		foreach($report_list as $report){ 
		?>			
		<td align="right" style="mso-number-format:'\@';">
		<?php 		
		foreach($report['head'] as $heads){
			if($heads['head_id']==$head['head_id']){
				echo $heads['amount'];
				$total_head_amount=$total_head_amount+$heads['amount'];
			}
		}
		?>
		</td>		
		<?php } ?>				
		<td align="right" style="mso-number-format:'\@';">
		<?php 
			echo sprintf("%.2f",$total_head_amount); 
			$total_amount=$total_amount+$total_head_amount;
		?>
		</td>
	</tr>
	
	<?php	
		$serial_no++;
	}
	?>
	<tr>
		<td colspan="<?php echo $total_student+2; ?>" align="right"><b>Total Amount : </b></td>
		<td align="right" style="mso-number-format:'\@';"><b><?php echo sprintf("%.2f",$total_amount); ?></b></td>		
	</tr>
</table>

-->