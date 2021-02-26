<?php
//    echo '<pre>';
//    print_r($info);    
?>
<h1>Select Exam</h1>
<form action="<?php echo site_url($active_module).'/index';?>" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Exam</b></td>
		<td>
		<b>
			<select class="textfield" id="exam_id" name="exam_id" required>
			<option value="">---Select Exam--</option>
			  <?php 
                            if(!empty($exams)){
                                foreach ($exams as $exam) { ?>
                        <option <?php if(!empty($exam_id) && $exam_id == $exam['id']){echo 'selected=selected';} ?> value="<?php echo $exam['id']; ?>">
                                    <?php echo $exam['title']; ?>
                                </option>
                            <?php }} ?>
			</select>	
			<input class="button" type="submit" value="Submit">	
		</b>
	</tr>
</table>
    <input type="hidden" name="class_id" value="<?php echo $info['class_id']; ?>" />    
    <input type="hidden" name="section_id" value="<?php echo $info['section_id']; ?>" />    
    <input type="hidden" name="student_id" value="<?php echo $info['student_id']; ?>" />
</form>
<?php
if(!empty($no_result)):
?>
<table>
    <tr>
        <td align="center"><b>No Record found!</b></td>
    </tr>
</table>
<?php            
endif;
?>   