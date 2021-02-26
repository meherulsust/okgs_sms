<html>
<head> 
<style>
#content{
	height:700px;
	/*background: transparent url('http://bv.rajcpsc.edu.bd/smsadmin/img/result_background.png') no-repeat;*/ 
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
    font-size:11px;
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
//    print_r($subjects);
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
			<div class="school_header school_name">Rajshahi Cantonment Public School & College</div>
			<div class="school_header_info address">Rajshahi Cantonment, Rajshahi</div>
			<div class="school_header_info school_name">Progress Report : Annual Examination, 2016.</div>
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
					<td width="10%">Name</td>
					<td width="55%">: <?php  echo $res['student_name']; ?></td>
					<td width="10%">Form</td>
					<td width="25%">: <?php echo $res['section_title']; ?></td>
				</tr>
				<tr>
					<td>Class</td>
					<td>: <?php echo $res['class_name']; ?></td>
					<td>House</td>
					<td>: <?php echo $res['house']; ?></td>
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
		<th rowspan="2">Subject</th>
		<th rowspan="2">Marks</th>
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
			if($subjective > 0){ 
				if($subjective >= 2){ 
			?>
				<th colspan="<?php echo $subjective+1; ?>">Term Total</th>
			<?php }else{ ?>
				<th colspan="<?php echo $subjective; ?>">Term Total</th>
			<?php 
				} 
			}
			?>
            <th width="85" rowspan="2">Grand Total<br /><?php if($res['class_id'] == 6 || $res['class_id'] == 8){}else{  ?>(10%+90%)<?php } ?></th>
            <th width="85" rowspan="2">Grade Point</th>
            <th width="85" rowspan="2">Letter Grade</th>
            <th width="130" rowspan="2">Class Highest</th>
            <th colspan="6">Final Result</th>
            <th align="center" width="85" rowspan="2">Result Status</th>
        </tr>
        <tr>            
            <!--<th>Pass</th>-->
            <?php if(!empty($subjects['ct1'])): ?><th>CT1</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><th>CT2</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><th>CT3</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><th>CT4</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><td>CT5</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><td>CT6</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><td>CT7</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><td>CT8</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><td>CT9</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><td>CT10</td><?php else: endif; ?>
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
            <th>Term Exam</th>
            <?php }else{ ?>
            <?php if(!empty($subjects['creative'])):  ?><th>Creative</th><?php else: endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['mcq'])):  ?><th>MCQ</th><?php else: endif; ?>
            <?php if(!empty($subjects['practical'])):  ?><th>Practical</th><?php else: endif; ?>
            <?php if(!empty($subjects['others'])):  ?><th>Others</th><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive1'])):  ?><td>Descriptive1</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive2'])):  ?><td>Descriptive2</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive3'])):  ?><td>Descriptive3</td><?php else: endif; ?>
            
            
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <th>Total</th>
            <?php } ?>
            

                <th align="center">HY <br />Mks</th>
                <th align="center">Yearly <br />Mks</th>
                <th align="center">(HY+Y)<br />Avg</th>
                <th align="center">GP</th>
                <th align="center">LG</th>
                <th align="center">CH<br />Avg</th>            
        </tr>
        <?php // print_r($results);
        if(!empty($results)):              
            $i=1;
            $class_highest_total = 0;
            $final_avg_total = 0;
            $grand_total = 0;
            foreach ($res['results'] as $result):                
        ?>
        <tr>
            <td align="left" width='200'><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td align="center"><?php if(!empty($result['full_mark'])): echo $result['full_mark']; else: echo '';  endif; ?></td>
<!--            <td align="center">50%</td>-->
             <?php if(!empty($subjects['ct1'])): ?><td align="center"><?php echo $result['ct1'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><td align="center"><?php echo $result['ct2'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><td align="center"><?php echo $result['ct3'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td align="center"><?php echo $result['ct4'];  echo ''; ?></td><?php else: endif; ?>
            <?php if($ct>1){ ?>
                <?php if($res['class_id'] == 6 || $res['class_id'] == 8){  ?>
                <td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td>
            <?php }else{ ?>
                <td align="center">
                <?php 
                        $ct_avg = ($result['ct1']+$result['ct2']+$result['ct3']+$result['ct4'])/$ct; 
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
            
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <td align="center"><?php echo $result['half_yearly_total'];  ?></td>
            <?php } ?>            
            
            <td align="center"><?php echo $result['yearly_grand_total'];  ?></td>
            <?php if($result['is_parent']!=1){ ?>
			<td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['yearly_gp'];  ?></td>
            <?php } ?>
			<?php if($result['is_parent']!=1){ ?>
			<td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['yearly_lg'];  ?></td>
            <?php } ?>
                <?php if(!empty($result['hmark']['yearly_class_highest'])): ?><td align="center"><?php echo $result['hmark']['yearly_class_highest'];  ?></td> <?php endif; ?>
            
            <td align="center"><?php if(!empty($result['half_yearly_mks'])): ?> <?php echo $result['half_yearly_mks'];  ?> <?php endif; ?></td>
            <td align="center"><?php if(!empty($result['yearly_grand_total'])): ?> <?php echo $result['yearly_grand_total'];  ?> <?php endif; ?></td>
            <td align="center"><?php if(!empty($result['final_avg_mks'])): ?> <?php echo $result['final_avg_mks'];  ?> <?php endif; ?></td>
            <?php if($result['is_parent']!=1){ ?>
			<td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['annual_gp'];  ?></td>
            <?php } ?>
            <?php if($result['is_parent']!=1){ ?>
                <td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['annual_lg'];  ?></td>
            <?php } ?>           
            
            <td align="center"><?php if(!empty($result['annual_class_highest_avg'])): ?> <?php echo $result['annual_class_highest_avg'];  ?> <?php endif; ?></td>
          
            <?php
            $grand_total = $grand_total + $result['full_mark'];
            $final_avg_total += $result['final_avg_mks'];
            $class_highest_total += $result['annual_class_highest_avg'];
            if($i==1)
            {
            if($res['class_id'] <= 4 || $res['class_id'] == '6' || $res['class_id'] == '8'){
                $add_drawing = 2;
            }else{$add_drawing = 1;}
            ?>
            <?php if(!empty($res['scale_matrix']['title'])): ?><td align="center" rowspan="<?php echo count($res['results']) + $add_drawing; ?>"> <b> <?php if($res['scale_matrix']['weight']<=0){ echo '<span class="result_title">Failed</span>';}else{ echo '<span class="address">Passed</span>'; } ?></b></td> <?php endif; ?>
            <?php } ?>
        </tr>		
        <?php   
        $i++;
        endforeach;
        ?>
        <?php
        if($add_drawing == 2){
        ?>
        <tr>
            <td align="left">Drawing</td>
            <td align="center" style="color:blue"></td>
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
            <?php if(!empty($subjects['ct1']) AND !empty($subjects['ct2'])): ?>
            <td align="center"></td>
            <?php else: endif; ?>
            <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
			<?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <td align="center"></td>
            <?php } ?>
            <td style="color:blue" align="center"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            
            
        </tr>
        <?php } ?>
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
            <?php if(!empty($subjects['ct1']) AND !empty($subjects['ct2'])): ?>
            <td align="center"></td>
            <?php else: endif; ?>
            <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <td align="center"></td>
            <?php } ?>
            <td style="color:blue" align="center"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center" style="color:blue"><b><?php if(isset($final_avg_total)){ echo $final_avg_total;}else{}  ?></b></td>
            <td align="center" style="color:blue"><b>GPA=<?php if($res['scale_matrix']['weight'] > 5){echo '5';} else{echo sprintf('%.2f',$res['scale_matrix']['weight']);}  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $res['scale_matrix']['title'];  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $class_highest_total;  ?> (Top Score)</b></td>
        </tr>
        <?php
            endif;
        ?>
    </table>
   
   <table class="main_table">
	<tr>		
		<th colspan="2" width="150">
		Evaluation System For Other Activities
		</th>
		<th colspan="2" width="150">
		First Term-end Examination,2016
		</th>
		<th colspan="3" width="319">
		Signature
		</th>
	</tr>
	<tr>
		<th width="7%">
		Grade
		</th>
		<th width="15%">
		Interpretation
		</th>
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
		Principal
		</th>
		<th width="10%">
		Guardian
		</th>
	</tr>
	<tr>        
		<td align="center">A</td>
		<td>Outstanding</td>
		<td>Total Students</td>
		<td align="center"><?php echo $total_students;  ?></td>
        <td rowspan="6"></td>
		<td rowspan="6"></td>
		<td rowspan="6"></td>
	</tr>
	<tr>
		<td align="center">B</td>
		<td>Good</td>
		<td>Working Days</td>
		<td align="center"><?php echo $working_days['total_working_days']; ?></td>		
	</tr>
	<tr>
		<td align="center">C</td>
		<td>Average</td>
		<td>Attendance</td>
		<td align="center"><?php echo $res['total_presence']; ?></td>
	</tr>
	<tr>
		<td align="center">D</td>
		<td>Below Average</td>
		<td>Discipline</td>
		<td></td>
	</tr>
	<tr>
		<td align="center">E</td>
		<td>Poor</td>
		<td>Cleanliness</td>
		<td></td>
	</tr>
	<tr>
		<td align="center"></td>
		<td align="center"></td>
		<td>Extra Curricular Activities</td>
		<td></td>
	</tr>
</table>
</div> 
</div> 
<pagebreak />   
<?php 
endforeach;   
?>
</body>
</html>


    
