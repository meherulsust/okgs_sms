<div class="box">
	<?php $this->tpl->load_element('student_accademic_info')?>
</div>
<div class="box">
    <h3>Student Payment Details </h3>
    <table>
        <tr>
			<th align="center" width="50">SL No.</th>
			<th>Fee Head</th>
			<th>Head Type</th>
			<th style="width:100px;">Amount(Tk)</th>
			<?php if($payment_status=='UNPAID'){ ?>
			<th style="width:100px;">Action</th>
			<?php } ?>
		</tr>
        <?php foreach($fees as $k=>$fee): ?>
        <tr>
			<td align="center"><?php echo $k+1 ?>.</td>
			<td style="padding-left:10px;"><?php echo $fee->title; if($fee->head_type =='WAIVER') echo ' (-)'; ?></td>
			<td><?php echo $fee->head_type;?></td>
			<td align="right"><?php echo $fee->ammount; ?></td>
			<?php if($payment_status=='UNPAID'){ ?>
			<td align="center">
				<a href="<?php echo site_url($active_module.'/edit_payment/'.$fee->id);?>">
					<img class="edit-icon" alt="Edit" src="<?php echo base_url();?>img/actn_edit.png"/>
				</a>
			</td>
			<?php } ?>
		</tr>
        <?php endforeach ?>
        <tr>
			<th colspan="3" align="right">Total Amount (Without Fine):</th>
			<td align="right"><b><?php echo $fee->total; ?></b></td>
			<td align="center"></td>
		</tr>        
    </table>   
</div>
<a href="<?php echo site_url($active_module.'/student_payment')?>" class="link-btn">Back To List</a>