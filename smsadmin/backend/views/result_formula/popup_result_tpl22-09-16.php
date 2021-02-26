<html>
<head> 
<style>
.school_header {
  font-size: 17px;
  font-weight: bold;
  text-align: center;
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
    border:1px solid #fff;
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
//        echo '<pre>';
//    print_r($results);  
    if(!empty($results)):
    ?>    
    <div>
    <table class="head_table" style="margin-top:10px;">
        <tr>
                <td width="10%"><strong>Name</strong></td>
                <td width="55%" colspan="3"><strong>: <?php  echo $results[0]['student_name']; ?></strong></td>
        </tr>
        <tr>
                <td>Class</td>
                <td>: <?php echo $results[0]['class_name']; ?></td>
                <td width="10%">Form</td>
                <td width="25%">: <?php echo $results[0]['section_title']; ?></td>
                <!--<td>House</td>
                <td>: <?php // echo $results[0]['house']; ?></td>-->
        </tr>
        <tr>
                <td>Roll</td>            
                <td>: <?php echo $results[0]['class_roll']; ?></td>  
                <td>ID</td>            
                <td>: <?php echo $results[0]['student_number']; ?></td> 
        </tr> 
    </table>
    <table class="main_table">
        <tr>
		<th rowspan="2">Subject</th>
		<th rowspan="2">Full Marks</th>
			<?php 
			if($ct > 0){ 
				if($ct >= 2){ 
			?>
				<!--<th colspan="<?php echo $ct+1; ?>">CT Marks</th>-->
			<?php }else{ ?>
				<!--<th colspan="<?php echo $ct; ?>">CT Marks</th>-->
			<?php 
				} 
			}
			?>
			
			<?php 
			if($subjective > 0){ 
				if($subjective >= 2){ 
			?>
				<th colspan="<?php echo $subjective; ?>">Term Total</th>
			<?php }else{ ?>
				<th colspan="<?php echo $subjective; ?>">Term Total</th>
			<?php 
				} 
			}
			?>
            <th width="85" rowspan="2">Grand Total<br /><?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){}else{  ?><?php } ?></th>
            <th width="85" rowspan="2">Grade Point</th>
            <th width="85" rowspan="2">Letter Grade</th>
            <th width="130" rowspan="2">Class Highest</th>
            <?php if($exam_id == '3'): ?><td colspan="6">Final Result</th> <?php endif;  ?>
            <th width="85" rowspan="2">Result Status</th>
        </tr>
        <tr>           
        <?php if($ct>1){ ?>
        <?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){  ?>
        <th>Total</th>
        <?php }else{ ?>
        <th>CT<br />(Avg)</th>
        <?php } } ?>  
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
        </tr>
        <?php 
        if(!empty($results)):              
            $i=1;
            $grand_total = 0;
            foreach ($results[0]['results'] as $result):  
        ?>
        <tr>
            <td align="left" width='200'><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td align="center"><?php if(!empty($result['full_mark'])): echo $result['full_mark']; else: echo '';  endif; ?></td>

            <?php if($ct>1){ ?>
            <?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){  ?>
                <td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td>
            <?php }else{ ?>
            <td align="center">
            <?php 
            $ct_avg = ($result['ct1']+$result['ct2']+$result['ct3']+$result['ct4'])/$ct; 
            echo sprintf('%0.2f',$ct_avg);
            ?>
            </td>
            <?php } } ?>            
            <?php if(!empty($subjects['creative'])):  ?><td align="center"><?php echo $result['creative'];  ?></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"><?php echo $result['mcq'];  ?></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"><?php if(isset($result['practical'])) {echo $result['practical'];} ?> </td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"><?php if(isset($result['others'])) {echo $result['others'];} ?> </td><?php endif; ?>
            
            <td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td>
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
                if(!empty($result['full_mark'])){
                    $grand_total = $grand_total + $result['full_mark'];
                }
            if($i==1)
            {
                if(!empty($results[0]['class_id'])){
                    if($results[0]['class_id'] <= 4 || $results[0]['class_id'] == '6' || $results[0]['class_id'] == '8'){
                        $add_drawing = 2;
                    }else{$add_drawing = 1;}
                }
            ?>
            <?php if(!empty($results[0]['scale_matrix']['title'])): ?><td align="center" rowspan="<?php echo count($results[0]['results']) + $add_drawing; ?>"> <b> <?php if($results[0]['scale_matrix']['weight']<=0){ echo '<span class="result_title">Failed</span>';}else{ echo '<span class="address">Passed</span>'; } ?></b></td> <?php endif; ?>
            <?php } ?>
        </tr>		
        <?php   
        $i++;
        endforeach;
        ?>
        <?php
        if(isset($add_drawing) && $add_drawing == 2){
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
            
            <td style="color:blue" align="center"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
            <td align="center" style="color:blue"></td>
        </tr>
        <?php } ?>
        <tr>
            <td align="left"></td>
            <td align="center" style="color:blue"><b><?php echo $grand_total; ?></b></td>
            <!--<?php if(!empty($subjects['ct1'])): ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><td align="center"></td><?php endif; ?>-->
            <?php if(!empty($subjects['ct1']) AND !empty($subjects['ct2'])): ?>
            <td align="center"></td>
            <?php else: endif; ?>
            <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($results[0]['total_mks']['total_mks_half_yearly'])): ?><td style="color:blue" align="center"> <b><?php echo $results[0]['total_mks']['total_mks_half_yearly'];  ?></b></td> <?php endif; ?>
            <td align="center" style="color:blue"><b>GPA=<?php if($results[0]['scale_matrix']['weight'] > 5){echo '5';} else{echo sprintf('%.2f',$results[0]['scale_matrix']['weight']);}  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $results[0]['scale_matrix']['title'];  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $max_total;  ?> (Top Score)</b></td>
        </tr>
        <?php
            endif;
        ?>
    </table>
   
</div> 
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
</body>
</html>


    