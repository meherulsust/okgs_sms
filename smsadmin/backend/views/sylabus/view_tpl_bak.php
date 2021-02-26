<div id="rightnow">
<h3 class="reallynow"><span>Syllabus details</span> <a href="<?php echo site_url($active_module.'/create')?>" class="add" title='Create new syllabus'>Add
New Syllabus</a> <br>
</h3>
<table class='view'>
<tbody>
<tr><th>Syllabus Title</th><td class='cln'>:</td><td class='txt'><?php echo $title; ?></td></tr>
<tr><th>Total Marks</th><td class='cln'>:</td><td class='txt'><?php echo $total_marks ?></td></tr>
<tr><th>Class</th><td class='cln'>:</td><td class='txt'><?php echo $class; ?></td></tr>
<tr><th>Form</th><td class='cln'>:</td><td class='txt'><?php echo $section ; ?></td></tr>
<tr><th>Description</th><td class='cln'>:</td><td class='txt'><?php echo $description; ?></td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><td colspan='3' class='btn-row'>
<a href='<?php echo site_url($active_module.'/edit/'.$id)?>' class='link-btn' title='Edit this record'>Edit</a>
<a href='<?php echo site_url($active_module.'/setup/'.$id)?>' class='link-btn' title='Set Up syllabus'>Configure</a>
<a href='<?php echo site_url($active_module.'/index')?>' class='link-btn' title='go to list'>Cancel</a>
</td></tr>
</tbody>
</table>
</div>

