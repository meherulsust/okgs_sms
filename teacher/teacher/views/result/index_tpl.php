<h1>Result List</h1>
<form action="<?php echo site_url($active_module) . '/index'; ?>" method="post" target="">
    <?php
//    echo '<pre>'; 
//    print_r($students);

    ?>
    <table class="list_table">
        <tr height="20">
            <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Class </b></td>
            <td>
                <select class="textfield" id="class_id" name="class_id" required>
                    <option value="">---Select Class--</option>
                    <?php foreach ($get_class as $val) { ?>
                    <option <?php if(isset($class_id) && $class_id == $val['id']){echo 'selected=selected';} ?> value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                    <?php } ?>
                </select>		
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Form</b> </td>
            <td>
                <select class="textfield" id="section_id" name="section_id" required>
                    <option value="">---Select Form--</option>     
                    <?php 
                        if(!empty($sections)){
                            foreach ($sections as $section) { ?>
                        <option <?php if($section_id == $section['id']){echo 'selected=selected';} ?> value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Exam</b> </td>
            <td>
                <select class="textfield" id="exam_id" name="exam_id" required>
                    <option value="">---Select Exam--</option>
                    <?php 
                    if(!empty($exams)){
                        foreach ($exams as $exam) { ?>
                    <option <?php if(isset($exam_id) && $exam_id == $exam['id']){echo 'selected=selected';} ?> value="<?php echo $exam['id']; ?>">
                            <?php echo $exam['title']; ?>
                        </option>
                    <?php }} ?>
                </select>
                <input class="button" type="submit" value="Submit">		
            </td>

        </tr>
    </table>
</form>
<?php 
    if(!empty($students)){
?>
<table width='100%' class="list_table">
            <thead>
                   <tr>
                      <th class="first">#</th>
                      <th class="first">Student Name</th>
                      <th class="first">Class Roll</th>
                      <th class="first">Student ID</th>
                      <th class="first">Action</th>
                   </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach ($students as $student):
                ?>
                <tr>
                    <td align="center"><?php echo $i; ?></td>
                    <td align="left"><?php echo $student['first_name']. ' '.$student['last_name'];   ?></td>
                    <td align="center"><?php echo $student['class_roll'];   ?></td>
                    <td align="center"><?php echo $student['student_number'];   ?></td>
                    <td align="center">
                        <a target="_blank" class="result_actn" title="Show result" href="<?php echo base_url(); ?>index.php/result/popup_result/<?php echo $student['class_id']; ?>/<?php echo $student['student_id']; ?>/<?php echo $student['section_id']; ?>/<?php echo $exam_id; ?>"><img class="result-icon" alt="Show result" src="<?php echo base_url();	?>images/actn_result.png"></a>
                    </td>
                </tr>
                
                <?php   
                        $i++;
                    endforeach;
                ?>
            </tbody>
        </table>
    <?php } else {  ?>
<table>
    <tr>
        <td align="center"><b>No Record found!</b></td>
    </tr>
</table>
    <?php }  ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#class_id').selectChain({
	    target: $('#section_id'),
	    value:'title',
	    url: '<?php echo site_url();?>/home/section',
	    type: 'post',
		data:{class_id: 'class_id'}
	});
    });
</script>
