<div id="rightnow">
<h3 class="reallynow"><span>Book details</span> <a href="<?php echo site_url('book/create')?>" class="add" title='Create new book'>Add
New Book</a> <br>
</h3>
<table class='view'>
<tbody>
<tr><th>Book Title</th><td class='cln'>:</td><td class='txt'><?php echo $title; ?></td></tr>
<tr><th>Fund Name</th><td class='cln'>:</td><td class='txt'><?php echo $fund; ?></td></tr>
<tr><th>Book Type</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($book_type)); ?></td></tr>
<tr><th>Writter Name</th><td class='cln'>:</td><td class='txt'><?php echo $writer_name; ?></td></tr>
<tr><th>Description</th><td class='cln'>:</td><td class='txt'><?php echo $description; ?></td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><td colspan='3' class='btn-row'>
<a href='<?php echo site_url($active_module.'/edit/'.$id)?>' class='link-btn' title='Edit this record'>Edit</a>
<a href='<?php echo site_url($active_module.'/index')?>' class='link-btn' title='go to list'>Cancel</a></td></tr>
</tbody>
</table>
</div>

