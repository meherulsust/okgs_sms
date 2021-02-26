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
                        <?php
                    $year = $this->session->userdata('db_postfix'); 
                    if($year == ''){
                        $year = date('Y-m-d');
                    }else{
                        $year = $year;
                    }
                    switch ($year){
                        case 2016:
                    ?>
                    <a class="result_actn" title="Show result" href="<?php echo base_url(); ?>index.php/result_formula/popup_result/<?php echo $student['class_id']; ?>/<?php echo $student['student_id']; ?>/<?php echo $student['section_id']; ?>/<?php echo $exam_id; ?>"><img class="result-icon" alt="Show result" src="<?php echo base_url();?>img/actn_result.png"></a>
                    <?php   
                        break;
                        case 2017:
                    ?>
                    <a class="result_actn" title="Show result" href="<?php echo base_url(); ?>index.php/result_formula/popup_2017_result/<?php echo $student['class_id']; ?>/<?php echo $student['student_id']; ?>/<?php echo $student['section_id']; ?>/<?php echo $exam_id; ?>"><img class="result-icon" alt="Show result" src="<?php echo base_url(); ?>/img/actn_result.png"></a>
                    <?php   
                        break;
                        default:
                        break;
                    ?>
                    <?php } ?>
                    </td>
                </tr>
                
                <?php   
                        $i++;
                    endforeach;
                ?>
            </tbody>
        </table>
</div>