<div id='box'>
<h3>Student admission details <br></h3>
<table class='view'>
<tbody>
<tr><th>Student Type</th><td class='cln'>:</td><td class='txt'><?php echo $student_type; ?></td></tr>
<tr><th>Class</th><td class='cln'>:</td><td class='txt'><?php echo $class; ?></td></tr>
<tr><th>Form</th><td class='cln'>:</td><td class='txt'><?php echo $section; ?> </td></tr>
<tr><th>Class Roll</th><td class='cln'>:</td><td class='txt'><?php echo $class_roll; ?> </td></tr>
<tr><th>Board Roll</th><td class='cln'>:</td><td class='txt'><?php echo $board_roll; ?> </td></tr>
<tr><th>Board Registration</th><td class='cln'>:</td><td class='txt'><?php echo $board_regino; ?> </td></tr>
<tr><th>Index Number</th><td class='cln'>:</td><td class='txt'><?php echo $index_no; ?> </td></tr>
<tr><th>Birth Registration No.</th><td class='cln'>:</td><td class='txt'><?php echo $birth_regino; ?> </td></tr>
<tr><th>Session</th><td class='cln'>:</td><td class='txt'><?php echo $session; ?> </td></tr>
<tr><th>Admission Fee</th><td class='cln'>:</td><td class='txt'><?php echo $fee; ?> </td></tr>
<tr><th>Status</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
<tr><th>Created At</th><td class='cln'>:</td><td class='txt'><?php echo mysql_to_audit($created_at); ?></td></tr>
<tr><th>Created By</th><td class='cln'>:</td><td class='txt'><?php echo 'Admin' ?></td></tr>
</tbody>
</table>
</div>