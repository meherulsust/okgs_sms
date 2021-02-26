<?php
	foreach($student_info as $val){	
?>

<div id="card">
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
		<tr>
			<td colspan="3" align="center">
				<div class="title"><?php echo strtoupper($school_info['name']);?></div> 
			</td>
		</tr> 		
		<tr>
			<td align="right" width="20%" valign="top">
				<img class="image" src="<?php echo base_url().'uploads/logo/'.$school_info['logo_file']; ?>"/>
			</td>
			<td align="center" width="50%" valign="top">
				<div class="type">(English Medium)</div> 
				<div class="address">809, Ibrahimpur, Dhaka 1206</div>
				<div class="title">EXAM PERMIT</div>						
			</td>
			<td align="left" width="30%" valign="bottom" style="padding-bottom:12px;">
				<span class="address">Reg. No. : <?php echo $val->student_number; ?></span>	
			</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle">
				<div class="name">Name :</div>
				<div class="class">Grade :</div>
			</td>
			<td width="80%" colspan="2" valign="middle">				
				<div class="name"><?php echo ucwords(strtolower($val->first_name. ' '.$val->last_name)); ?></div>	
				<div class="class"><?php echo $val->class.' ('.$val->section.')'; ?></div>	
			</td>			
		</tr>
		<tr>
			<td colspan="3">
				<div class="admit_description">Student has been permitted</div>				
			</td>						
		</tr>		
		<tr>				
			<td align="left" colspan="2">				
				<!-- <img class="image" style="padding:0 10px;" src="<?php echo base_url().'img/sign.png';?>"/>  -->
			</td>
			<td align="center">				
				<img class="image" src="<?php echo base_url().'img/sign.png';?>"/>
			</td>
		</tr>	
		<tr>				
			<td align="left" colspan="2" valign="top">			
				<span class="name" style="border-top:1px solid #000;padding:0 10px;">Financial Clearance</span>
			</td>
			<td align="center" valign="top" style="border-top:1px solid #000;">			
				<span class="name">Principal</span>
			</td>
		</tr>		
	</table>
</div>

<?php
	}
?>