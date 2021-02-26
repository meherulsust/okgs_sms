<div id='box'>
<h3>Sylabus Evaluation Type Details <br></h3>
<table class='view'>
<tbody>
<tr><th>Sylabus</th><td class='cln'>:</td><td class='txt'><?php echo $sylabus; ?></td></tr>
<tr><th>Evaluation Type</th><td class='cln'>:</td><td class='txt'><?php echo $evaluation_type; ?> </td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><th>Created By</th><td class='cln'>:</td><td class='txt'><?php echo 'Admin' ?></td></tr>
</tbody>
</table>
</div>