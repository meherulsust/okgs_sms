<h1>Note List</h1>
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL. No.</b></th>
		<th width="30%" align="center"><b>Note Name</b></th>
		<th width="30%" align="center"><b>Description </b></th>
		<th width="20%" align="center"><b>Subject</b></th>
		<th width="10%" align="center"><b>Action </b></th>	
	</tr>
	<?php if($notebook_list): ?>
	<?php 
	$i=1;
	foreach($notebook_list as $note):
	?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $note['title']; ?></td>	
		<td><?php echo $note['description']; ?></td>
		<td><?php echo $note['subject']; ?></td>	
		<td align="center">
			<a href="<?php echo site_url('book_list/note_download/'.$note['file_name']); ?>" title="Download">
				<img src="<?php echo base_url();?>images/download.png"/>
			</a>
			<a href="<?php echo site_url('book_list/note_view/'.$note['file_name']); ?>" target="_blank">Read</a>
		</td>	
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='3'>No note found.</td>		
	</tr>
        <?php endif ?>
</table>
<body>
    <div id="pdfContainer" class = "pdf-content">
    </div>
</body>
