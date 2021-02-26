<form action="#" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Class </b></td>
		<td>
		<b><?php //echo $class; ?>
		
			<select class="textfield" id="class_id" name="class_id">
			<option value="">---Select Class--</option>
			  <?php foreach($get_class as $val){?>
			  <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
			  <?php }?>
			</select>		
		</b>
	</tr>
</table>
</form>
<div id="book_list">
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
</div>

<script>
	$(document).ready(function() {
           $('#class_id').change(function(){
			var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>/book_list/get_book_list",
                data: "class_id=" + val,
                success: function(response) {
                    $('#book_list').html(response);
                }
            });
            return false;
        });
    }); 
</script>

