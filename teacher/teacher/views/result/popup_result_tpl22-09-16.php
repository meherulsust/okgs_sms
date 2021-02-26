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
.main_table th{
    color: #000000;
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

<?php 
    $exam_id = $this->input->get('exam_id');  
    $class_id = $this->input->get('class_id');  
    if(!empty($exam_types)){
        $num_exam_types = array_count_values($exam_types);        
    }
//    echo '<pre>';
//    print_r($results);
    if(!empty($results)):
    ?>   
<table style="width:100%;">
    <tr>
        <td style="text-align: center;"><b><?php echo $current_exam; ?></b></td>
    </tr>
</table>
    <table style="width:100%;">
        <tr>
            <td width="10%">Name : </td>
            <td width="60%"><?php  echo $results[0]['student_name']; ?></td>
            <td width="10%">Form : </td>
            <td width="20%"><?php echo $results[0]['section_title']; ?></td>
        </tr>
        <tr>
            <td>Class : </td>
            <td><?php echo $results[0]['class_name']; ?></td>
        </tr>
        <tr>
            <td>Roll : </td>            
            <td><?php echo $results[0]['class_roll']; ?></td>  
            <td>ID : </td>            
            <td><?php echo $results[0]['student_number']; ?></td> 
        </tr> 
    </table>
    
    <?php
        $nurserykg = 0;
        $onetwo = 0;
        if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){$nurserykg = 2;}
        if($results[0]['class_id'] == 1 || $results[0]['class_id'] == 2){$onetwo = 2;}
    ?>

    <table class="main_table">
        <tr>
		<th rowspan="<?php if($nurserykg == 2){echo '1';}else{ echo '2';}?>">Subject</th>
		<th width="85" rowspan="<?php if($nurserykg == 2){echo '1';}else{ echo '2';}?>">Full Marks</th>
                <?php 
                if($nurserykg == 2){echo '';}else{
                    if($ct > 0){ 
                            if($ct >= 2){ 
                    ?>
                            <th colspan="<?php echo $ct+1; ?>">CT Marks</th>
                    <?php }else{ ?>
                            <th colspan="<?php echo $ct; ?>">CT Marks</th>
                    <?php 
                        } 
                    }
                }
                ?>
			
                <?php                 
                if($nurserykg == 2){
                    echo '';
                }else{
                if($subjective > 0){ 
                    if($subjective >= 2){ 
                ?>
                    <th colspan="<?php echo $subjective+1; ?>">Term-end Marks</th>
                <?php }else{ ?>
                    <th rowspan="<?php echo $subjective+1; ?>">Term-end Marks</th>
                <?php 
                        } 
                    }
                }
                ?>
            <th width="85" rowspan="<?php if($nurserykg == 2){echo '1';}else{ echo '2';}?>">Subject Total</th>
            <th width="85" rowspan="<?php if($nurserykg == 2){echo '1';}else{ echo '2';}?>">Grade Point</th>
            <th width="85" rowspan="<?php if($nurserykg == 2){echo '1';}else{ echo '2';}?>">Letter Grade</th>
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <th width="130" rowspan="2">Class Highest</th>            
            <th width="85" rowspan="2">Result Status</th>
            <?php if($onetwo == 2){echo '';}else{  ?>
            <th width="65" rowspan="2">Position</th>
            <?php }} ?>
        </tr>
        <?php if($nurserykg == 2){echo '';}else{  ?>
        <tr>            
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
                <?php if($nurserykg == 2){  ?>
                <th>Total</th>
            <?php }else{ ?>
                <th>CT<br />(Avg)</th>
                <?php 
                    } 
                } 
            ?>  
            <?php if(!empty($subjects['creative']) AND empty($subjects['mcq'])){  ?>
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
        </tr>
        <?php } ?>
        <?php // print_r($results);
 //echo $subjects['creative'];
        if(!empty($results)):              
            $i=1;
            $j = 0;
            $grand_total = 0;
            foreach ($results[0]['results'] as $result):                
        ?>
        <tr>
            <td align="left" width='200'><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td align="center"><?php if(!empty($result['full_mark'])): echo $result['full_mark']; else: echo '';  endif; ?></td>
            
            
            <?php if(!empty($subjects['ct1'])): ?><td align="center"><?php echo $result['ct1'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><td align="center"><?php echo $result['ct2'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><td align="center"><?php echo $result['ct3'];  echo ''; ?></td><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td align="center"><?php echo $result['ct4'];  echo ''; ?></td><?php else: endif; ?>
            <?php if($ct>1){ ?>
            <?php if($nurserykg == 2){ ?>
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
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <?php if(!empty($subjects['creative'])):  ?><td align="center"><?php echo $result['creative'];  ?></td> <?php endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"><?php echo $result['mcq'];  ?></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"><?php if(isset($result['practical'])) {echo $result['practical'];} ?> </td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"><?php if(isset($result['others'])) {echo $result['others'];} ?> </td><?php endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){ ?>
            <td align="center"><?php echo $result['half_yearly_total'];  ?></td>
            <?php } ?>            
            
            <td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td>
            <?php if($result['is_parent']!=1){ ?>
                <td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['half_yearly_gp'];  ?></td>
            <?php } ?>
            <?php if($result['is_parent']!=1){ ?>
                <td align="center" <?php if($result['child_id']>0){ echo 'rowspan="2"';} ?>><?php echo $result['half_yearly_lg'];  ?></td>
            <?php } ?>
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <?php if(!empty($result['hmark']['half_yearly_class_highest'])): ?><td align="center"><?php echo $result['hmark']['half_yearly_class_highest'];  ?></td> <?php endif; ?>
            <?php } ?>
            <?php
            $grand_total = $grand_total + $result['full_mark'];
            if($i==1)
            {
            if($results[0]['class_id'] <= 4 || $results[0]['class_id'] == '6' || $results[0]['class_id'] == '8'){
                $add_drawing = 2;
            }else{$add_drawing = 1;}
            ?>
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <?php if(!empty($results[0]['scale_matrix']['title'])): ?><td align="center" rowspan="<?php echo count($results[0]['results']) + $add_drawing; ?>"> <b> <?php if($results[0]['scale_matrix']['weight']<=0){ echo '<span class="result_title">Failed</span>';}else{ echo '<span class="address">Passed</span>'; } ?></b></td> <?php endif; ?>
            <?php if($onetwo == 2){echo '';}else{  ?>
            <?php 
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
                if($j == 0){
            ?>
            <td align="center" rowspan="<?php echo count($results[0]['results']) + $add_drawing; ?>"> <?php if(isset($result['position'])){ echo $result['position'];}else {echo '';} ?></td>  
            <?php }}}} ?>
        </tr>		
        <?php  
        $j++;
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
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <td align="center"></td>
            <td align="center"></td>
            <?php } ?>
            <td align="center"></td>            
            <td align="center"></td>
        </tr>
        <?php } ?>
        <tr>
            <td align="left" style="color:blue; font-weight:bold;">Grand Total</td>
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
            <?php if($nurserykg == 2){echo '';}else{  ?>
                <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
                <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
                <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
                <?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <td align="center"></td>
            <?php } ?>
            <?php if(!empty($results[0]['total_mks']['total_mks_half_yearly'])): ?><td style="color:blue" align="center"> <b><?php echo $results[0]['total_mks']['total_mks_half_yearly'];  ?></b></td> <?php endif; ?>
            <td align="center" style="color:blue"><b>GPA=<?php if($results[0]['scale_matrix']['weight'] > 5){echo '5';} else{echo sprintf('%.2f',$results[0]['scale_matrix']['weight']);}  ?></b></td>
            <td align="center" style="color:blue"><b><?php echo $results[0]['scale_matrix']['title'];  ?></b></td>
            <?php if($nurserykg == 2){echo '';}else{  ?>
            <td align="center" style="color:blue"><b><?php echo $max_total;  ?> (Top Score)</b></td>
            <?php } ?>
        </tr>
    <?php endif; ?>
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
<br />