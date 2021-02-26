<div id="rightnow">
<h3 class="reallynow"><span>Course evaluation component details</span> <a href="<?php echo site_url($active_module.'/newcomp')?>" class="add" title='Create course attribute'>Add Course Attrubute</a> <br>
</h3>
<table class='view'>
<tbody>
<tr><th>Course Attribute Name</th><td class='cln'>:</td><td class='txt'><?php echo $title; ?></td></tr>
<tr><th>Description</th><td class='cln'>:</td><td class='txt'><?php echo $description; ?></td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><td colspan='3' class='btn-row'>
<a href='<?php echo site_url($active_module.'/editevaltype/'.$id)?>' class='link-btn' title='Edit this record'>Edit</a>
<a href='<?php echo site_url($active_module.'/evaltype')?>' class='link-btn' title='go to list'>Cancel</a>
</td></tr>
</tbody>
</table>
</div>

