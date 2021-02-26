<div id="rightnow">
<h3 class="reallynow"><span>Result Scale details</span> <a href="<?php echo site_url($active_module.'/newscale')?>" class="add" title='Create New Scale'>Add
New Result Scale</a> <br>
</h3>
<table class='view'>
<tbody>
<tr><th>Result Scale Title</th><td class='cln'>:</td><td class='txt'><?php echo $title; ?></td></tr>
<tr><th>Description</th><td class='cln'>:</td><td class='txt'><?php echo $description; ?></td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><td colspan='3' class='btn-row'>
<a href='<?php echo site_url($active_module.'/rsedit/'.$id)?>' class='link-btn' title='Edit this record'>Edit</a>
<a href='<?php echo site_url($active_module.'/rsconfig')?>' class='link-btn' title='Set Up Scale'>Configure Scale</a>
<a href='<?php echo site_url($active_module.'/scale')?>' class='link-btn' title='go to list'>Cancel</a>
</td></tr>
</tbody>
</table>
</div>

