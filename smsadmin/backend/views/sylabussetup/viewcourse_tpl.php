<div id='box'>
<h3>Course Details <br></h3>
<table class='view'>
<tbody>
<tr><th>Sylabus</th><td class='cln'>:</td><td class='txt'><?php echo $sylabus; ?></td></tr>
<tr><th>Course Title</th><td class='cln'>:</td><td class='txt'><?php echo $course_title; ?> </td></tr>
<tr><th>Total Marks</th><td class='cln'>:</td><td class='txt'><?php echo $total_marks; ?> </td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<?php foreach($course_evals as $eval):?>
<tr><th><?php echo ($eval['eval_type']=='NUMBER')? $eval['title'].' Marks': $eval['title']?></th><td class='cln'>:</td><td class='txt'><?php echo $eval['value']; ?></td></tr>
<?php endforeach ?>
<?php foreach($course_attrs as $attr):?>
<tr><th><?php echo ($attr['eval_type']=='NUMBER')? $attr['title'].' Marks': $attr['title']?></th><td class='cln'>:</td><td class='txt'><?php echo $attr['value']; ?></td></tr>
<?php endforeach ?>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><th>Created By</th><td class='cln'>:</td><td class='txt'><?php echo 'Admin' ?></td></tr>
</tbody>
</table>
</div>