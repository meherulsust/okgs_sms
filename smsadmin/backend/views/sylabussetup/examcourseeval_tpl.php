<?php  
    $default_courses = $this->coursemodel->get_course_by_sylabus($sylabus_id);
    $evals = $this->evalmodel->get_eval_by_sylabus($sylabus_id);
    $courses = $this->setmodel->get_course($id);
    if($courses){
        $courses = array_assoc_by_key($courses, 'course_id');
    }

    $course_evals = $this->setmodel->get_course_eval($id);
    if($course_evals){
        $course_evals = array_group_by_key($course_evals, 'course_id','eval_type_id');
    }
    
//    echo '<pre>';
//    print_r($course_evals);
//    exit();
    if($default_courses && $evals ):
   $num=0;
   
?>
<form name='frm_exam_course_eval' id='frm-exam-course-eval' method='post' action='<?php echo site_url($active_module.'/saveexameval')?>' >
    <input type="hidden" name="sylabus_exam_type_id" value="<?php echo $id ?>" />
<table class="marks-tbl">
    <?php foreach($default_courses as $course ): 
     
       $total_marks        = isset($courses[$course['course_id']]['total_marks']) ? $courses[$course['course_id']]['total_marks']: '';
       $exam_course_id     = isset($courses[$course['course_id']])? $courses[$course['course_id']]['exam_course_id']:'' ;
     ?>
    <tr>    <th><?php echo $course['course_title'] ?></th><td class="cln">:</td>
        <td>
           <input type="hidden" name="eval[<?php echo $course['course_id'] ?>][id]" value="<?php echo $exam_course_id ?>" />
        <table class="tbl-inner">
        <?php foreach($evals as $eval): 
             $value = isset($course_evals[$course['course_id']][$eval['eval_id']])? $course_evals[$course['course_id']][$eval['eval_id']]['value']:''; 
             $course_eval_id = isset($course_evals[$course['course_id']][$eval['eval_id']])? $course_evals[$course['course_id']][$eval['eval_id']]['course_eval_id']:'';
         ?>
            <tr><th> 
                 <input type="hidden" name="eval[<?php  echo $course['course_id'] ?>][type][<?php echo $num ?>][id]" value="<?php echo $course_eval_id  ?>" />   
                 <input type="hidden" name="eval[<?php echo $course['course_id'] ?>][type][<?php echo $num ?>][eval_id]" value="<?php  echo $eval['eval_id'] ?>" />   
                <label for="<?php echo $course['course_id'].'_'.$eval['eval_id'] ?>"><?php echo $eval['title'] ?></label></th><td class="cln">:</td><td>
                    <input id="<?php echo $course['course_id'].'_'.$eval['eval_id'] ?>" type="text" class="txt" name='eval[<?php echo $course['course_id'] ?>][type][<?php echo $num++ ?>][value]' value="<?php echo $value; ?>" /></td></tr>
        <?php endforeach; ?>
        </table> 
        </td>
        <th class="t-marks"><label for="marks_<?php echo $course['course_id']?>">Total Marks</label></th><td class="cln">:</td><td><input id="marks_<?php echo $course['course_id']?>" type="text" name='eval[<?php echo $course['course_id'] ?>][total_marks]' class="txt" readonly="true" value="<?php echo $total_marks; ?>"/></td>
     </tr>
    <?php endforeach; ?>
     <tr class="btn-tr"><th>&nbsp;</th><td class="btn-container" colspan="5">
             <input type="submit" value="Submit" class="btn" /> 
             <input type="reset" value="Reset" class="btn" />
             <input type="button" value="Cancel" id="cancel-btn" class="btn"/> 
         </td></tr>
</table>  
 </form>
<?php else: ?>

<?php endif; ?>
