<h1>Payment List</h1>
<?php echo $this->session->flashdata('message');?>

<?php if(!empty($topup_list)){ ?>
<table class="list_table">
	<tr>
		<th>Receiver</th>
		<th>Package</th>
		<th>Amount</th>
		<th>Price</th>
		<th>Date & Time</th>
		<th>Type</th>		
		<th>Payment Status</th>
		<th>Topup Status</th>
		<th>Inquiry</th>
	</tr>
	<?php foreach($topup_list as $val){ ?>
	<tr>
		<td><?php echo $val['receiver'];?></td>		
		<td><?php echo $val['package_name'];?></td>
		<td><?php echo $val['amount'];?></td>
		<td><?php echo $val['total_price'];?></td>
		<td><?php echo $val['request_time'];?></td>
		<td><?php echo $val['type'];?></td>
		<td align="center">
		<?php 
			if($val['payment_status']=='Success'){ $color='Green'; }
			if($val['payment_status']=='Pending'){ $color='Orange'; }
			echo '<span style="color:'.$color.'">'.$val['payment_status'].'</span>';
		?>
		</td>
		<td align="center">
		<?php 
			if($val['status']=='Success'){ $color='Green'; }
			if($val['status']=='Pending'){ 
				$color='Orange'; 
			?>
			<script src="http://code.jquery.com/jquery-latest.js"></script> 
			<script>
			var refreshId = setInterval(function()
			{
				$('#status').load('topup_user/check_status/<?=$val['transaction_id'];?>');
			}, 10000);
			</script>
			<?php	
			}
			if($val['status']=='Failed'){ $color='Red'; }
			echo '<div id="status"><span style="color:'.$color.'">'.$val['status'].'</span></div>';
		?>
		</td>
		<td align="center"><a href="<?=$site_url;?>topup_user/send_inquiry/<?=$val['id'];?>"><img style="padding-top:4px;" src="<?=$base_url;?>images/inquiry.png"/></a></td>
	</tr>
	<?php } ?>
</table>

<!--- start pagination ----->
<form name='frm_pagination' id='frm_pagination' method='post'>
	<div id="tnt_pagination">
		<span class="question">Page <strong><?=$cur_page ?>/<?=$total_page ?>&nbsp;</strong></span> 
		<span id='pagination-bar'><?php $this->tpl->pagination(); ?></span>
		<span class="question">Total <strong><?=$total_record?> </strong> records found</span>
	</div> 
</form>	
<!--- End pagination ----->

<?php }else{ ?>		
		<p>No topup list</p>
<?php } ?>		

<script type='text/javascript'>
	$(document).ready(function() {
		$('#rec_per_page').bind('change',function(){
			$('#frm_pagination').submit();
		});

		$('#pagination-bar a').click(function(){
			var url=$(this).attr('href');
			$('#frm_pagination').attr('action',url).submit();
			return false;
		}); 

		$('#grid-board th a').click(function(){
			var url=$(this).attr('href');
			$('#frm_pagination').attr('action',url).submit();
			return false;
		}); 
	});

</script>		

	   

		
		