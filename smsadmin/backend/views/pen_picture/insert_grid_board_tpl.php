<style type="text/css">
    .result_sheet_input{
        width: 100px;
    }
    .result_entry_table{
        border: none;
    }
    select{
        width:96% !important;
        margin: 2% !important;
    }
/*    .result_entry_table tr{
        border: none;
    }*/
</style>
<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 class='grid_title_bar'>Insert Template</h3>
    
<form name='frm-insert-grid-board' id='frm-insert-grid-board' method='post' action='<?php echo site_url($active_module.'/insert_result')?>' >
    
        <?php 
//            echo '<pre>';
//            print_r($form_elements);
            if(!empty($form_elements)):
                 $x= 0;
        ?>
    <table>        
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Class:</b></td>
            <td width="40%" style="font-size: 15px;"><?php echo $entry_details['class_title']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Form:</b></td>
            <td style="font-size: 14px;"><?php echo $entry_details['section_title']; ?></td>
        </tr>
    </table>
    <br />     
    <table width='100%' class="result_entry_table">
        <tr>
            <th width="150">Student Name</th>
            <th width="50">Roll</th>
            <th width="130">Comments</th>
            <th width="130">Discipline</th>
            <th width="130">Cleanliness</th>
            <th width="130">Extra-Curricular Activities</th>
        </tr>
        <?php foreach ($form_elements as $form_element){ ?>
        <tr>
            <td><?php echo $form_element['student_name'];  ?></td>
            <td align="center"><?php echo $form_element['class_roll'];  ?></td>
            <td>
                <textarea name="pen_picture_temaplte_id<?php echo $x; ?>" id="pen_picture_temaplte_id<?php echo $x; ?>" style="background: none; height: 40px; width: 200px; margin-bottom: 2px;" placeholder="Your comment here"></textarea>
            </td>
            <td>
                <select class="activity_select_input" name="discipline<?php echo $x; ?>" id="discipline<?php echo $x; ?>">
                    <option value="0">--Select--</option>
                    <?php   
                        foreach($activities as $key=>$activity){
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $activity; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="activity_select_input" name="cleanliness<?php echo $x; ?>" id="cleanliness<?php echo $x; ?>">
                    <option value="0">--Select--</option>
                    <?php   
                        foreach($activities as $key=>$activity){
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $activity; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="activity_select_input" name="co_curricular_activities<?php echo $x; ?>" id="co_curricular_activities<?php echo $x; ?>">
                    <option value="0">--Select--</option>
                    <?php   
                        foreach($activities as $key=>$activity){
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $activity; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <input type="hidden" name="student_id<?php echo $x; ?>" id="student_id<?php echo $x; ?>" value="<?php echo $form_element['student_id']; ?>" />
        <?php   $x++; } ?>
    </table>
    
    <input type="hidden" name="row_count" id="row_count" value="<?php echo $x; ?>" />
    <input type="hidden" name="class_id" id="class_id" value="<?php echo $info['class_id']; ?>" />
    <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $info['exam_id']; ?>" />
    <input type="hidden" name="section_id" id="section_id" value="<?php echo $info['section_id']; ?>" />
            
            <tr>
                <td>&nbsp;</td>
                <td align="right" colspan="7" class="btn-container">
                    <input type="submit" class="btn" value="Submit" name="submit" id="submit">
                    <input type="reset" class="btn" value="Reset" name="button">
                    <button class="btn" id="btn-cancel" type="button">Cancel</button>
                </td>
            </tr>
    </table>
        <?php
        else:
        ?>
    <table>
        <tr>
            <td align="center"><b>No Record found!</b></td>
        </tr>
    </table>
        <?php            
        endif;
        ?>        

</form>
</div>
