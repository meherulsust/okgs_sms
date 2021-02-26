<html>
<head> 
<style>
#content{
	height:700px;
	background: transparent url('http://www.educlerk.com/imsn/smsadmin/img/imsn_result_border.png') no-repeat; 
	text-align: center; 
	padding:40px 50px 50px 50px;
}
.school_header {
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  color:#005518;
}
.school_name,.address{
	color:#005518;
}
.result_title{
	color:#C80017;
}
.school_header_info {
  bottom: 14px;
  font-size: 16px;
  padding: 0;
  position: relative;
  text-align: center;
}

.main_table{
    width:100%;  
    margin-top:15px;
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr{
    width:100%;      
}
.main_table tr th{
	padding:2px 4px;
    font-size:12px;
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr td{
    font-size:12px;
    padding:2px 4px;
    border:1px solid #000;
    border-collapse: collapse;
}

.head_table{
    width:100%;  
    border-collapse: collapse;
    
} 
.bottom_table_left {
  border: 1px solid #000;
  border-collapse: collapse;
  margin-top: 15px;
  width: 100%;
  font-size:12px;
}
.bottom_table_right {
  border: 1px solid #000;
  border-collapse: collapse;
  margin-top: 15px;
  width: 100%;
  font-size:12px;
}
</style>
</head>
<body>
<?php 
    $exam_id = $this->input->get('exam_id');  
    $class_id = $this->input->get('class_id');  
    if(!empty($exam_types)){
        $num_exam_types = array_count_values($exam_types);        
    }
//    echo '<pre>';
//    print_r($results);    
   
    ?>
    <?php    
    foreach ($results as $res):     
    ?>  
	<div id="container">
    <div id="content">
	<table class="head_table">
	<tr>
		<td align="left" width="22%">
			
		</td>
		<td align="center" width="46%">
                    <div class="school_header school_name"><?php echo strtoupper($school_info['name']); ?></div>
                    <div class="school_header_info address"><?php echo strtoupper($school_info['address1']); ?></div>
                    <div class="school_header_info school_name">Progress Report : <?php if($res['class_id'] == '37'){ echo 'Model Test-2016';}else{ echo $exam_name; } ?></div>
		</td>
		<td align="right" rowspan="2" width="22%">
                    <table class="main_table">
                        <tr>
                            <th align="center" colspan="3"></b>GRADING</b></th>
                        </tr>
                        <?php foreach($scale_matrix_list as $val){ ?>
                        <tr>
                            <td align="left" width="100"><?php echo $val['grade_title']; ?></td>
                            <td align="center" width="70"><?php echo $val['title']; ?></td>
                            <td align="center" width="70"><?php echo $val['weight']; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
		</td>
	</tr>
	<tr>
            <td colspan="2">			
            <table class="head_table" style="margin-top:30px;">
                <tr>
                    <td style="width: 10%;">Name</td>
                    <td style="width: 70%;">: <?php  echo $res['student_name']; ?></td>
                    <td style="width: 10%;">Form</td>
                    <td style="width: 10%;">: <?php echo $res['section_title']; ?></td>
                </tr>
                <tr>
                    <td>Class</td>
                    <td>: <?php echo $res['class_name']; ?></td>
                    <!--<td>House</td>
                    <td>: <?php echo $res['house']; ?></td>-->
                </tr>
                <tr>
                    <td>Roll</td>            
                    <td>: <?php echo $res['class_roll']; ?></td>  
                    <td>ID</td>            
                    <td>: <?php echo $res['student_number']; ?></td> 
                </tr> 
            </table>
            </td>
	</tr>	 
</table>
    
    <table class="main_table">
        <tr>
		<th <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Subject</th>
                <th <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?> <?php if($res['class_id'] < 32){?>style="width: 15%" <?php } ?>> <?php if($res['class_id'] < 32){?> Full Marks <?php }else{ ?> Marks <?php } ?> </th>
			<?php 
			if($ct > 0){ 
				if($ct >= 2){ 
			?>
				<th colspan="<?php echo $ct+1; ?>">CT Marks</th>
			<?php }else{ ?>
				<th colspan="<?php echo $ct; ?>">CT Marks</th>
			<?php 
				} 
			}
			?>
			
			<?php 
                        if($res['class_id'] > 31){
			if($subjective > 0){ 
				if($subjective >= 2){ 
			?>
				<th colspan="<?php echo $subjective; ?>">Term Total</th>
			<?php }else{ ?>
				<th colspan="<?php echo $subjective; ?>">Term Total</th>
			<?php 
                        } } }
			?>
            <th width="85" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>> <?php if($res['class_id'] < 32){?> Obtain Marks<?php }else{ ?> Grand Total<br /> <?php } ?> </th>
            <th width="85" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Grade Point</th>
            <th width="85" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Letter Grade</th>
            <th width="130" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Class Highest</th>
            <th width="85" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Result Status</th>
            <th width="65" <?php if($res['class_id'] > 31){?>rowspan="2"<?php } ?>>Position</th>
        </tr>
        <tr>            
            <?php if(!empty($subjects['ct1'])): ?><th>CT1</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><th>CT2</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><th>CT3</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><th>CT4</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><th>CT5</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><th>CT6</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><th>CT7</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><th>CT8</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><th>CT9</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><th>CT10</th><?php else: endif; ?>
            <?php if(!empty($subjects['assessment1'])):  ?><th>Assessment1</th><?php else: endif; ?>
            <?php if(!empty($subjects['assessment2'])):  ?><th>Assessment2</th><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test1'])):  ?><th>Oral Test1</th><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test2'])):  ?><th>Oral Test2</th><?php else: endif; ?>
            
            <?php if($ct>1){ ?>
                <?php if($res['class_id'] == 6 || $res['class_id'] == 8){  ?>
                <th>Total</th>
            <?php }else{ ?>
                <th>CT<br />(Avg)</th>
            <?php 
                } 
            } 
            ?>  
            <?php if(!empty($subjects['creative']) AND empty($subjects['mcq'])){  ?>
            <?php if($res['class_id'] > 31){?><th>Term Exam</th><?php } ?>
            <?php }else{ ?>
            <?php if(!empty($subjects['creative'])):  ?><th>Creative</th><?php else: endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['mcq'])):  ?><th>MCQ</th><?php else: endif; ?>
            <?php if(!empty($subjects['practical'])):  ?><th>Practical</th><?php else: endif; ?>
            <?php if(!empty($subjects['others'])):  ?><th>Others</th><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive1'])):  ?><td>Descriptive1</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive2'])):  ?><td>Descriptive2</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive3'])):  ?><td>Descriptive3</td><?php else: endif; ?>
        </tr>
        
        <?php // print_r($results);
        if(!empty($results)):              
            $i=1;
            $j = 0;
            $grand_total = 0;
            foreach ($res['results'] as $result):                
        ?>
        <tr>
            <td align="left" width='200'><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?><?php if(isset($res['optional_sub_id'])  && $res['optional_sub_id'] == $result['subject_id']) {echo ' (Optional)';}else{echo '';} ?></td>
            <td align="center"><?php if(!empty($result['full_mark'])): echo $result['full_mark']; else: echo '';  endif; ?></td>
            <?php if(!empty($subjects['ct1'])): ?><td align="center"><?php echo $result['ct1'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><td align="center"><?php echo $result['ct2'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><td align="center"><?php echo $result['ct3'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td align="center"><?php echo $result['ct4'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['assessment1'])):  ?><td align="center"><?php echo $result['assessment1'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['assessment2'])):  ?><td align="center"><?php echo $result['assessment2'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test1'])):  ?><td align="center"><?php echo $result['oral_test1'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test2'])):  ?><td align="center"><?php echo $result['oral_test2'];  echo ''; ?></td><?php else: endif; ?>
            
            <?php if($ct>1){ ?>
            <?php if($res['class_id'] == 6 || $res['class_id'] == 8){  ?>
                <td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td>
            <?php }else{ ?>
                <td align="center">
            <?php 
                $ct_avg = ($result['ct1']+$result['ct2']+$result['ct3']+$result['ct4']+$result['assessment1']+$result['assessment2']+$result['oral_test1']+$result['oral_test2'])/$ct; 
                echo sprintf('%0.2f',$ct_avg);
            ?>
                </td>
            <?php 
                } 
            } 
            ?>            
            <?php if(!empty($subjects['creative'])):  ?><td align="center"><?php echo $result['creative'];  ?></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"><?php echo $result['mcq'];  ?></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"><?php if(isset($result['practical'])) {echo $result['practical'];} ?> </td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"><?php if(isset($result['others'])) {echo $result['others'];} ?> </td><?php endif; ?>
            
            <?php if($res['class_id'] > 31){?><td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td><?php } ?>    
            <?php if($result['is_parent']!=1){ ?>
            <td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['half_yearly_gp'];  ?></td>
            <?php } ?>
            <?php if($result['is_parent']!=1){ ?>
            <td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['half_yearly_lg'];  ?></td>
            <?php } ?>
                <?php if(!empty($result['hmark']['half_yearly_class_highest'])): ?><td align="center"><?php echo $result['hmark']['half_yearly_class_highest'];  ?></td> <?php endif; ?>
            <?php if($exam_id == '3'): ?>
            <td align="center"><?php if(!empty($result['mid_term_mks'])): ?> <?php echo $result['mid_term_mks'];  ?> <?php endif; ?></td>
            <td align="center"><?php echo $final_avg = ($result['mid_term_mks'] + $result['yearly_grand_total'])/2;   ?></td>
            <td align="center"></td>
            <?php endif; ?>
            <?php
			$grand_total = $grand_total + $result['full_mark'];
            if($i==1)
            {
            if($res['class_id'] <= 4 || $res['class_id'] == '6' || $res['class_id'] == '8'){
                $add_drawing = 2;
            }else{$add_drawing = 1;}
            ?>
            <?php if(!empty($res['scale_matrix']['title'])): ?><td align="center" rowspan="<?php echo count($res['results']) + $add_drawing; ?>"> <b> <?php if($res['scale_matrix']['weight']<=0){ echo '<span class="result_title">Failed</span>';}else{ echo '<span class="address">Passed</span>'; } ?></b></td> <?php endif; ?>
            <?php } ?>
        <?php 
            if(!empty($result['position'])){
                if($result['position'] == 1){
                    $result['position'] = '1st';
                }elseif($result['position'] == 2){
                    $result['position'] = '2nd';
                }elseif($result['position'] == 3){
                    $result['position'] = '3rd';
                }elseif($result['position'] == 0){
                    $result['position'] = '';
                }else{
                    $result['position'] = $result['position'].'th';
                }
            }
                if($j == 0){
        ?>
            <td align="center" rowspan="<?php echo count($res['results']) + $add_drawing; ?>"> <?php if(!empty($result['position'])){echo $result['position'];}else{echo '';} ?></td>  
        <?php }
		 ?>
        </tr>
        <?php  
        $j++;
        $i++;
        endforeach;
        ?>
        
        <tr>
            <td align="left"></td>
            <td align="center" style="color:blue"><b><?php echo $grand_total; ?></b></td>
            <?php if(!empty($subjects['ct1'])): ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['assessment1'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['assessment2'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['oral_test1'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['oral_test2'])):  ?><td align="center"></td><?php endif; ?>
            
            <?php if(!empty($subjects['ct1']) AND !empty($subjects['ct2'])): ?>
            <td align="center"></td>
            <?php else: endif; ?>
            <?php if($res['class_id'] > 31){?>
                <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php // if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <!--<td align="center"></td>-->
            <?php // } ?>
            <?php if(!empty($res['total_mks']['total_mks_half_yearly'])): ?><td style="color:blue" align="center"> <b><?php echo number_format($res['total_mks']['total_mks_half_yearly'], 2, '.', '');  ?></b></td> <?php endif; ?>
            <td align="center" style="color:blue"><b>GPA=<?php if($res['scale_matrix']['weight'] > 5){echo '5';} else{echo sprintf('%.2f',$res['scale_matrix']['weight']);}  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $res['scale_matrix']['title'];  ?></b></td>
            <td align="center" style="color:blue"><b><?php if($topper_score > 0){ echo number_format($topper_score, 2, '.', '');  ?> (Top Score) <?php } else {echo ''; } ?></b></td>
        </tr>
        <?php
            endif;
        ?>
    </table>
        <div class="bottom_containers" style="width: 100%;">
        <div class="bottom_container_left" style="float:left; width: 29%;">
            
            <table class="bottom_table_left" border="1">
	<tr>		
		<th colspan="2" width="332">
		Evaluation System For Other Activities
		</th>		
	</tr>
	<tr>
           
            <th width="15%">
            Interpretation
            </th>
             <th width="7%">
            Grade
            </th>
        </tr>
	<tr>   
            <td>Outstanding</td>
            <td align="center">A</td>
            
            
	</tr>
	<tr>
                <td>Good</td>
		<td align="center">B</td>
		
	</tr>
	<tr>
            <td>Average</td>	
            <td align="center">C</td>
		
	</tr>
	<tr>
            <td>Below Average</td>
            <td align="center">D</td>
		
	</tr>
	<tr>
            <td>Poor</td>
            <td align="center">E</td>
		
	</tr>
</table>
        </div>
            <div class="bottom_container_right" style="float:right; width: 70%;">
        <table class="bottom_table_right" border="1">
            <tr>
		<th colspan="2" width="240">
		<?php echo substr($exam_name, 0, -5); ?>
		</th>
                <th colspan="1" width="319">
		Comment & Signature
                </th>
                <th width="319" colspan="2">
		Signature
                </th>
            </tr>
            <tr>
                <th width="18%">
                Other Information
                </th>
                <th width="7%">
                Statement
                </th>
                <th width="33%">
                Form Master
                </th>
                <th width="10%">
                Headmaster
                </th>
                <th width="10%">
                Guardian
                </th>
	</tr>
        <tr>
            <td>Total Students</td>
            <td align="center"><?php echo $total_students;  ?></td>
            <td rowspan="6" valign="top"><?php if(!empty($res['activities']['pen_picture_temaplte_id'])) { echo $res['activities']['pen_picture_temaplte_id'];} ?></td>
            <td rowspan="6"></td>
            <td rowspan="6"></td>
        </tr>
        <tr>
            <td>Working Days</td>
            <td align="center"><?php echo $working_days; ?></td>
        </tr>
        <tr>
            <td>Attendance</td>
            <td align="center"><?php echo $res['total_presence']; ?></td>
        </tr>
        <tr>
            <td>Discipline</td>
            <td align="center"><?php if(!empty($res['activities']['discipline'])) { echo $res['activities']['discipline'];} ?></td>
        </tr>
        <tr>
            <td>Cleanliness</td>
            <td align="center"><?php if (!empty($res['activities']['cleanliness'])) {echo $res['activities']['cleanliness'];} ?></td>
        </tr>
        <tr>
            <td>Extra Curricular Activities</td>
            <td align="center"><?php if (!empty($res['activities']['co_curricular_activities'])) {echo $res['activities']['co_curricular_activities']; } ?></td>
        </tr>
          
            
        </table>        
        </div>
    </div>
</div> 
</div> 
<pagebreak />   
<?php 
endforeach;   
?>
</body>
</html>


    