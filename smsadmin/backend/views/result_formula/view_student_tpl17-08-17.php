<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div class='clr'></div>
<div id='grid'>
<div id="box">
  <h3 class='grid_title_bar'>Student List</h3>
	<table width='100%'>
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
<!--                    <a class="view_actn" title="View details of this scale" href="http://localhost/school/smsadmin/index.php/exam/regiview/7"><img class="view-icon" alt="View" src="http://localhost/school/smsadmin/img/actn_view.png"></a>
                        <a class="edit_actn" title="Edit this scale" href="http://localhost/school/smsadmin/index.php/exam/regiedit/7"><img class="edit-icon" alt="Edit" src="http://localhost/school/smsadmin/img/actn_edit.png"></a>
                        <a class="marks_actn" title="Assign exam marks" href="http://localhost/school/smsadmin/index.php/exam/marks/7"><img class="marks-icon" alt="Assign Marks" src="http://localhost/school/smsadmin/img/actn_marks.png"></a>-->
                        <a class="result_actn" title="Show result" href="<?php echo base_url(); ?>index.php/result_formula/popup_result/<?php echo $student['class_id']; ?>/<?php echo $student['student_id']; ?>/<?php echo $student['section_id']; ?>/<?php echo $exam_id; ?>"><img class="result-icon" alt="Show result" src="<?php echo base_url();?>img/actn_result.png"></a>
<!--                    <a class="transcript_actn" title="Show transcript" href="http://localhost/school/smsadmin/index.php/exam/transcript/7"><img class="transcript-icon" alt="Transcript" src="http://localhost/school/smsadmin/img/actn_transcript.png"></a>
                        <a class="del_actn" title="Delete this record" href="http://localhost/school/smsadmin/index.php/exam/regidel/7"><img class="del-icon" alt="Delete" src="http://localhost/school/smsadmin/img/actn_del.png"></a>-->
                    </td>
                </tr>
                
                <?php   
                        $i++;
                    endforeach;
                ?>
            </tbody>
        </table>
</div>