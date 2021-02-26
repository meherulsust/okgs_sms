<style type="text/css">
    .result_sheet_input{
        width: 100px;
    }
    .result_entry_table{
        border: none;
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
    <h3 class='grid_title_bar'>Insert Result</h3>
    
<form name='frm-insert-grid-board' id='frm-insert-grid-board' method='post' action='<?php echo site_url($active_module.'/insert_result')?>' >
    
        <?php // print_r($info);
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
        <tr>
            <td style="text-align: center; font-size: 14px;"><b>Subject:</b></td>
            <td style="font-size: 14px;"><?php echo $entry_details['subject_title']; ?></td>
        </tr>
    </table>
    <br />        
    <table width='100%' class="result_entry_table">
        <?php
                foreach ($form_elements as $form_element):
        ?>
        <tr>
            <td colspan="<?php echo $col = sizeof($form_element['form_fields'])*2 - 2; ?>">
                <b>Name :</b> &nbsp; <?php echo $form_element['student_name'];  ?>
                &nbsp;
                <b>Roll :</b> &nbsp; <?php echo $form_element['class_roll'];  ?>
            </td>
<!--            <td colspan=""><b>Roll No.</b></td>
            <td><?php // echo $form_element['class_roll'];  ?></td>-->
        </tr>        
        <tr>
        <?php
            foreach ($form_element['form_fields'] as $key=>$element):
        ?>
            <!--<td><?php echo $element;  ?></td>-->
            <td>
                <input class="result_sheet_input" name="<?php echo $key; ?><?php echo $x; ?>" id="<?php echo $key; ?><?php echo $x; ?>" placeholder="<?php echo $element;  ?>" value="" />
               
            </td>
        <input type="hidden" name="student_id<?php echo $x; ?>" id="student_id<?php echo $x; ?>" value="<?php echo $form_element['student_id']; ?>" />
        <?php
            endforeach;
        ?>
                        
                        
            <?php 
             $x++;
             endforeach;
             ?>            
            <input type="hidden" name="row_count" id="row_count" value="<?php echo $x; ?>" />
            <input type="hidden" name="class_id" id="class_id" value="<?php echo $info['class_id']; ?>" />
            <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $info['subject_id']; ?>" />
            <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $info['exam_id']; ?>" />
            <input type="hidden" name="section_id" id="section_id" value="<?php echo $info['section_id']; ?>" />
            
            <tr>
                <td>&nbsp;</td>
                <td align="right" colspan="2" class="btn-container">
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
<script type="text/javascript">
    $(document).ready(function () {
       
 $(".result_sheet_input").on("keypress",function (event) {
     var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
           alert('Digits Only');
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }     
        
    });
        
       
    });    
    
</script>