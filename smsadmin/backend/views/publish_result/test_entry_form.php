<form name='frm-test-entry' id='frm-test-entry' method='post' action='<?php echo site_url($active_module.'/create_result')?>' >
    <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <?php echo $this->test_entry_form->render();  ?>
        <tr>
            <th class="lbl">
                <label for="test_entry_form_student_id">
                    Student
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <select id="student_id" name="student_id" class="">
                    <option>---Select Student---</option>
                    <?php 
                        if(!empty($students)):
                            foreach ($students as $student):
                    ?>
                    <option value="<?php echo $student['student_id']; ?>"> <?php echo $student['first_name']; ?></option>
                    <?php   
                            endforeach;
                        endif;
                    ?>
                </select>
            </td>            
        </tr>        
        <?php
            if(!empty($form_fields)):
            foreach ($form_fields as $field=>$title):  
        ?>
        <tr>
            <th class="lbl">
                <label for="test_entry_form_class_id">
                    <?php echo $title; ?>
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <input name="<?php echo $field; ?>" id="<?php echo $field; ?>" />
            </td>            
        </tr>
        <?php
            endforeach;  
        endif;
        ?>
        
        <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="btn-container">         
            <input type="submit" class="btn" value="Submit" name="submit">
            <button class="btn" type="button" id="btn-cancel">Cancel</button>
        </td>
    </tr>
    </table>
</form>

<script type="text/javascript">
    $('#test_entry_form_subject_id').change(function(){
        var student_class = $('#test_entry_form_class_id').val();
        var exam = $('#test_entry_form_exam_id').val();
        var subject = $('#test_entry_form_subject_id').val();
        
        if(exam == '' || student_class == ''){
            alert('Please Select Class and Examination tot generate the form!');
        }else{
            window.location.replace('<?php echo base_url(); ?>index.php/publish_result/test_entry?class=' + student_class +'&exam='+ exam +'&subject='+ subject);
        }
    });
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
        };
    
  $(window).load(function(){
        var class_id = getUrlParameter('class');
        var subject_id = getUrlParameter('subject');
        var exam_id = getUrlParameter('exam');
       $('#test_entry_form_class_id').val(class_id);
       $('#test_entry_form_exam_id').val(exam_id);
       $('#test_entry_form_subject_id').val(subject_id);
   });  

</script>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo base_url(); ?>index.php/publish_result";
       }); 
    });
</script>