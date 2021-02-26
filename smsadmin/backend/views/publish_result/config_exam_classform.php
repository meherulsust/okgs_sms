<?php 
    $edit_id = $this->uri->segment(3); 
    $onvalid = $this->uri->segment(2); 
    if(!empty($edit_id) || $onvalid == 'update'):
?>
<form name='frm-config-exam-classes' id='frm-config-exam-classes' method='post' action='<?php echo site_url($active_module.'/update')?>' >
<?php else:  ?>
<form name='frm-config-exam-classes' id='frm-config-exam-classes' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<?php endif;  ?>
<fieldset id="config_exam_classes"><legend>Configure Exam for Classes</legend>
    <?php $exam_types = '';
        if(!empty($config_data['marks_id'])){
            $exam_types =  explode(',', $config_data['marks_id']);  
        }
    ?>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->config_exam_classform->render(); ?>
    <tr>
        <th class="lbl">
            <label for="config_exam_class_exam_type1">Exam Types</label>
        </th>
        <td class="cln">:</td>
        <td>
            <div class="class_test_checkbox">
            <?php 
                $x = 1;
                foreach ($form_checkboxes as $form_checkbox):
            ?>
            <input type="checkbox" id="config_exam_class_exam_type<?php echo $x; ?>" value="<?php echo $form_checkbox['id']; ?>" name="exam_type[]" <?php if(!empty($exam_types)){if(in_array($form_checkbox['id'], $exam_types)){echo 'checked';}else{echo '';}} ?>><?php echo $form_checkbox['title']; ?>
            <br>
            <?php if($x%7 == 0): ?>
            </div>
            <div class="class_test_checkbox">
            <?php endif;  ?>
                       
            <?php 
                $x++;
                endforeach;  
            ?>
            </div> 
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="btn-container">
            <input type="hidden" name="config_id" value="<?php echo $edit_id; ?>">
            <input type="submit" class="btn" value="Submit" name="submit">
            <input type="reset" class="btn" value="Reset" name="button">
            <button class="btn" id="btn-cancel" type="button">Cancel</button>
        </td>
    </tr>
</table>
</fieldset>
<?php echo $this->config_exam_classform->render_hidden(); ?>
</form>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo base_url(); ?>index.php/publish_result";
       }); 
    });
</script>
<?php
    $uri_subject = $this->input->get('subject');
    if(!empty($uri_subject)):
        
?>
<script>   
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
            var total_marks = getUrlParameter('total_marks');
           $('#config_exam_class_class_id').val(class_id);
           $('#config_exam_class_subject_id').val(subject_id);
           $('#config_exam_class_exam_id').val(exam_id);
           $('#config_exam_class_total_marks').val(total_marks);
   });      
</script> 
<?php 
endif;
?>