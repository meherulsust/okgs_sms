<h1>Syllabus List</h1>
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL. No.</b></th>
		<th width="30%" align="center"><b>Syllabus Name</b></th>
		<th width="10%" align="center"><b>Action </b></th>	
	</tr>
	<?php if($syllabus_list): ?>
	<?php 
	$i=1;
	foreach($syllabus_list as $note):
	?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $note['title']; ?></td>	
		<td align="center">
			<a href="<?php echo site_url('syllabus_list/syllabus_download/'.$note['syllabus_image']); ?>" title="Download">
				<img src="<?php echo base_url();?>images/download.png"/>
			</a>
			<a href="<?php echo site_url('syllabus_list/syllabus_view/'.$note['syllabus_image']); ?>" target="_blank">Read</a>
		</td>	
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='4'>No Syllabus List found.</td>		
	</tr>
        <?php endif ?>
</table>
<body>
    <div id="pdfContainer" class = "pdf-content">
    </div>
</body>