<?php $this->tpl->set_js(array('exam_marks_form')); ?>
<form name='frm-marks' id='frm-marks' method='post' action='<?php echo site_url($active_module.'/savemarks')?>' >
    <table border='0' class='marks-tbl'>
        <?php foreach($course_details as $course_id => $rs):?>
         <tr><th><?php echo $rs[0]['course'] ?>&nbsp;:</th> 
           <td><table border='0'>
                 <?php foreach($rs as $row):?>
                   <tr><th><?php echo $row['eval_type'] ?></th><td class='cln'>:</td>
                       <td>
                           <?php if(array_key_exists($row['cset_id'],$marks_saved)): ?>
                            <input type='text' class="txt required"  name="result[<?php echo $row['cset_id'] ?>][marks]" value='<?php echo $marks_saved[$row['cset_id']]['obtain_marks']; ?>' />
                            <input type='hidden'  name="result[<?php echo $row['cset_id'] ?>][id]" value='<?php echo $marks_saved[$row['cset_id']]['id']; ?>' />
                            <span class="req">*</span>
                             <?php else: ?>
                              <input type='hidden'  name="result[<?php echo $row['cset_id'] ?>][id]"  />
                             <input type='text' class="txt required"   name="result[<?php echo $row['cset_id'] ?>][marks]"  />
                             <span class="req">*</span>
                           <?php endif; ?>
                       </td></tr>
                 <?php endforeach; ?>
            </table> </td>
        </tr>      
        <?php endforeach; ?>
        <tr class='btn-tr'><th>&nbsp;</th><td class='btn-container'><input type='submit' value='Submit'  class='btn' /><button id="btn-marks-cancel" class="btn" type="button">Cancel</button></td></tr>
    </table>
    <input type='hidden' name='reg_id' value='<?php echo $reg_id ?>' />
</form>