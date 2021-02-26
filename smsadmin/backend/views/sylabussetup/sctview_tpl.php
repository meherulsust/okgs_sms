<div id='box'>
<h3>Sylabus Course Type Details <br></h3>
<table class='view'>
<tbody>
<tr><th>Sylabus</th><td class='cln'>:</td><td class='txt'><?php echo $sylabus; ?></td></tr>
<tr><th>Course Type</th><td class='cln'>:</td><td class='txt'><?php echo $course_type; ?> </td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><th>Created By</th><td class='cln'>:</td><td class='txt'><?php echo 'Admin' ?></td></tr>
</tbody>
</table>
</div>