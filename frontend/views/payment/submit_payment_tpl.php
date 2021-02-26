<style type="text/css">
.receipt_head tr{
	border:1px solid #ddd;
}
.receipt_head tr td{
	padding:10px 4px;
}
.receipt_body tr td{
	border:1px solid #ddd;
	padding:10px 6px;
}
</style>

<h1>Confirm Payment</h1>		
	<h6 align="center"><img src="<?php echo base_url().'smsadmin/uploads/logo/'.$logo_file;?>" style="width:80px;"/></h6>
	<h4 align="center"><?php echo strtoupper($school_info['name']); ?></h4>
	<h6 align="center"><?php echo strtoupper($school_info['address1']);  ?></h6>
	<h6 align="center"><?php echo strtoupper($school_info['address2']);  ?></h6>
	
	<table width="98%" align="center" class="receipt_head">		
		<tr>
            <td align="center"><b><?php echo $head; ?></b></td>			
		</tr>	
		<tr>
			<td align="center"><b>Total Amount = <?php echo $amount; ?></b></td>							
		</tr>		
	</table>	
	</br>	
	<form action="<?php echo site_url('payment/save') ?>" method="post" name="payment">
		<h6 align="center"><input  class="button" type="submit" value="Confirm Payment"/></h6>
	</form>
	
	<br/>