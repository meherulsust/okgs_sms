<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$report_file_name);
	header("Pragma: no-cache");
	header("Expires: 0");		
?>
<style>

</style>
<h2><?php echo $school_info['name'];?></h2>
<span>Balance Sheet Report</span><br/>
<span><?php echo $report_title; ?></span><br/>

<table border="1" width="100%" id="report" style="text-align:center">		
	<tr>
		<td align="center" rowspan="2"><b>SL. No.</b></td>
		<td align="center" rowspan="2"><b>Title</b></td>
		<td align="center" rowspan="2"><b>Balance Type</b></td>
		<td align="center" rowspan="2"><b>Created Date</b></td>
		<td align="center" rowspan="2"><b>Month</b></td>
		<td align="center" rowspan="2"><b>Year</b></td>
		<td align="center" rowspan="2"><b>Amount</b></td>		
	</tr>
	<tr></tr>
	<?php 
	
		$total_amount=0;
		$serial_no=1;
		if($report !='')
		foreach($report as $rep){ 	
	?>
	<tr>
		<td align="center"><b><?php echo $serial_no; ?></b></td>
		<td><?php echo $rep['title']; ?></td>
		<td><?php echo $rep['balance_type']; ?></td>
		<td><?php echo $rep['date']; ?></td>
		<td><?php echo $rep['month']; ?></td>
		<td><?php echo $rep['year']; ?></td>	
		<td><?php echo $rep['ammount']; ?></td>	
	</tr><br/>
	<?php	
		$serial_no++;
	}
	?>	
	<tr></tr>
	<tr style="color:red; font-weight:bold; background:yellow">
		<td></td>
		<td>Total Income</td>
		<td><?php echo $total['total']; ?></td>
		<td>Total Expenditure</td>
		<td><?php echo $cost['cost']; ?></td>
		<td>Net Balance</td>
		<td><?php echo $total['total']-$cost['cost'].'.00'; ?></td>
	</tr>
</table>
