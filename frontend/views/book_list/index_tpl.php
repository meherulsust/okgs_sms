<h1>
	Book List 
	<div style="float:right;">	
		<a href="<?php echo site_url('book_list/download') ?>" title="Download">
			<img src="<?php echo base_url();?>images/download.png"/>
		</a>
	</div>
</h1>
	<?php echo $this->session->flashdata('message');?>

<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL. No.</b></th>
		<th width="30%" align="center"><b>Book Name</b></th>
		<th width="40%" align="center"><b>Writer Name </b></th>		
		<th width="20%" align="center"><b>Book Link </b></th>		
	</tr>
	<?php if($book_list): ?>
	<?php 
	$i=1;
	foreach($book_list as $book):
	?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $book['title']; ?></td>	
		<td><?php echo $book['writer_name']; ?></td>		
		<td><a target="_blank" href="<?=$book['link'];?>"><?php echo $book['link']; ?></a></td>		
	</tr>
    <?php 
	$i++;
	endforeach; 
	?>
    <?php else: ?>
	<tr>
		<td align="center" colspan='3'>No book is found.</td>		
	</tr>
        <?php endif ?>
</table>
