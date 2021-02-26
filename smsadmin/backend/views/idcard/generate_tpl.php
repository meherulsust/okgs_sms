<div id="card">
	
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
		<span class="bg" align="center"><img width="200" src="<?php echo base_url() . 'uploads/logo/'.$school_info['logo_file'] ?>" /></span>
		<tr>
			<td align="center" width="25%" valign="top">
				<img class="logo" src="<?php echo base_url().'uploads/logo/'.$school_info['logo_file']; ?>"/>
			</td>
		</tr>
		<tr>		
			<td colspan="1" align="center">
				<div class="title"><?php echo strtoupper($school_info['name']);?></div> 
			</td>
			
		</tr> 
		<!--<tr>		
			<td colspan="1" align="center">
				<div class="title"><img width="270" src="<?php echo base_url();?>img/name.png"></div> 
			</td>
			
		</tr> -->
		<tr>
			<td align="left" width="25%" valign="top">
				<img class="image" src="<?php echo base_url().'uploads/std_photo/'.$file_name; ?>"/>
			</td>
		</tr>
		<tr>
			<td align="left">
				<span>Name:</span>
				<span class="name"><?php echo ucwords(($first_name). ' '.($last_name)); ?></span>	
			</td>
		</tr>	
		<tr>
			<td align="left">
				<span>Father's Name:</span>
				<span class="name"><?php echo ucwords(($f_first_name). ' '.($f_last_name)); ?></span>	
			</td>
		</tr>
		<tr>
			<td align="left">
				<span>Mother's Name:</span>
				<span class="name"><?php echo ucwords(($m_first_name). ' '.($m_last_name)); ?></span>	
			</td>
		</tr>
		<tr>
			<td align="left">
				<span>Blood Group:</span>
				<span class="name"><?php echo $blood_group; ?></span>	
			</td>
		</tr>
		<tr>
			<td align="left">
				<span>ID:</span>
				<span class="name"><?php echo $student_number; ?></span>	
			</td>
		</tr>
		<tr>
			<td align="right" width="25%"><img width="80" height="20"  style="bottom:0;" src="<?php echo base_url();?>img/sign.png"></td>
			
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td align="right" width="25%">			
				<span style="margin-right:10px;">Principal</span>
			</td>
		</tr>
	</table>
</div>
