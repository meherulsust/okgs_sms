<?php $this->tpl->set_js('grid');?>
<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div class='clr'></div>
<div id='grid'>
<div id="box">
    <h3 class='grid_title_bar'>Student List</h3>
    <table>        
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Class:</b></td>
            <td width="40%" style="font-size: 15px;"><?php echo $entry_details['class_title']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Form:</b></td>
            <td style="font-size: 14px;"><?php echo $entry_details['section_title']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Subject:</b></td>
            <td style="font-size: 14px;"><?php echo $entry_details['subject_title']; ?></td>
        </tr>
    </table>
 
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
                    <td align="left"><?php echo $student['student_name'];   ?></td>
                    <td align="center"><?php echo $student['class_roll'];   ?></td>
                    <td align="center"><?php echo $student['student_number'];   ?></td>
                    <td align="center">
                        <a class="del_actn" title="Remove Subject" href="<?php echo base_url(); ?>index.php/result_formula/remove_subject_entry/<?php echo $class_id; ?>/<?php echo $student['student_id']; ?>/<?php echo $section_id; ?>/<?php echo $exam_id; ?>/<?php echo $subject_id; ?>">
                            <img class="" alt="Remove Subject" src="<?php echo base_url(); ?>img/actn_del.png">
                        </a>
                    </td>
                </tr>
                
                <?php   
                        $i++;
                    endforeach;
                ?>
            </tbody>
        </table>
</div>