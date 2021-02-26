<style>
 #result-details-tbl table tr{
                border-bottom: 1px solid #D9E6F0;
            }
.result_detail td{
			width:33.33%;
		}
</style>	

		
<?php if ($result_exists): ?>
<?php $this->tpl->set_js(array('exam_result')) ?>
    <table id="result-details-tbl">
        <tr>
			<th>Serial No.</th>
			<th>Name of Subject</th>
			<!--dyanamic Eval type-->
			<th style="min-width:200px;">
				<table><tr><th colspan="3">Marks Details</th></tr>
					<tr>
						 <?php $i=1;foreach ($results as $result): ?>
						 <?php foreach ($result['eval_types'] as $k => $eval): ?>
						 <?php if($i==1)
						 echo '<th>'. $eval['title'].'</th>'; ?>
						 <?php endforeach; ?>	 
						 <?php $i++;endforeach; ?>
					</tr>
				</table>
			</th>
			<!--end-->
			<th>Total Marks</th>
			<th>Letter Grade</th>
			<th>Grade Point</th>
            <th>GPA<?php if ($final_result['weight_with_additional']): ?><br><small>(without additional subject.)</small><?php endif; ?></th>
            <?php if ($final_result['weight_with_additional']): ?>
            <th>GPA</th><?php endif; ?>
		</tr>
        <?php $num = 1; foreach ($results as $result): ?> 
        <?php if (isset($result['is_additional'])) {
            $additional_result = $result;
            continue;
        } ?>
        <tr><td><?php echo $num; ?></td><td><?php echo $result['course']; ?> </td>
                <td class="tbl-cont">
					<table class="result_detail">
						<tr class="lrow"> 
								<?php  foreach(($result['eval_types']) as $eval):?>
								<td><?php echo $eval['obtain_marks']; ?></td>
								<?php endforeach; ?>
						</tr>
					</table>			
					<!--<table>
					<?php foreach ($result['eval_types'] as $k => $eval): ?>
					<tr <?php if (($k + 1) == count($result['eval_types'])) echo 'class="lrow"' ?> ><td class="lbl"><?php echo $eval['title'] ?> &nbsp;</td><td><?php echo $eval['obtain_marks'] ?></td></tr>
					<?php endforeach; ?>
					</table>-->
                </td>
                <td><?php echo $result['obtain_marks']; ?></td><td><?php echo $result['title']; ?></td>
                <td><?php echo $result['weight'] ?></td>
                <?php if ($num == 1): ?>
                    <td rowspan="<?php echo $final_result['weight_with_additional']? (count($results) -1) :count($results); ?>" id="gpa"><?php echo $final_result['weight'] ?></td>
                    <?php if ($final_result['weight_with_additional']): ?>
                        <td rowspan="<?php echo count($results) ?>" id="agpa"><?php echo $final_result['weight_with_additional'] ?></td>
                    <?php endif; ?>
                     
                <?php endif; ?>
				<?php $num++; endforeach; ?>
        </tr>
       
        <?php if (isset($additional_result)): ?>
             <tr> <td colspan='7' style='font-weight: bolder; text-align: left;'>Additional Subject:</td></tr>
             <tr>
                <td><?php $result = $additional_result; echo $num; ?></td><td><?php echo $result['course']; ?> </td>
                <td class="tbl-cont">
                    <table>
                <?php foreach ($result['eval_types'] as $k => $eval): ?>
                            <tr <?php if (($k + 1) == count($result['eval_types'])) echo 'class="lrow"' ?> ><td class="lbl"><?php echo $eval['title'] ?> &nbsp;</td><td><?php echo $eval['obtain_marks'] ?></td></tr>
                 <?php endforeach; ?>
                    </table>
                </td>
                <td><?php echo $result['obtain_marks']; ?></td><td><?php echo $result['title']; ?></td>
                <td class="tbl-cont" ><table><tr><td>GP Above <?php echo $result['score_subtract'] ?></td><tr class="lrow"><td> <?php  echo $result['additional_weight']; ?></td></tr></table>
               </tr>  
		<?php endif; ?>
       
    </table>
	<table>
		<!--<tr><th colspan='4' align='left'>Final result:</th></tr>-->
		<tr><th class="lbl">Final Result:</th><td><?php if($final_result['is_pass']) echo 'Pass'; else echo 'Fail'; ?></td><th class="lbl">Grade:</th><td><?php echo $final_result['title'] ; ?></td></tr>
	</table>
    <input type="hidden" id="reg_id" value="<?php echo $reg_id ?>" />
    <div class="btn-container" style="margin-top:20px;padding-left:250px;">
        <?php if($exam_result_num > 0 ): ?>
        <button class="btn" id="update-btn" style="width:auto;">Update Result</button>
        <div id='dialog-confirm'><div>Are you sure? You want to recalculate this result.</div></div>
        <?php else: ?>
        <button class="btn" id="save-btn">Save Result</button>
        <?php endif; ?>
        <button class="btn" id="cancel-btn">Cancel</button>
    </div>
<?php else: ?>
    <div id="box" style="height:50%; padding-top: 20%;"> 
        <ul class="system_messages"> <li class="red"><span class="ico"></span><strong class="system_title">Exam marks is not found. Please insert exam marks first.</strong></li> </ul> 
    </div>
<?php endif; ?>
 