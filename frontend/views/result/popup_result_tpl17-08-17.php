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
<div id="printview">
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
            <td>Roll : </td>            
            <td><?php echo $results[0]['class_roll']; ?></td>  
            <td>ID : </td>            
            <td><?php echo $results[0]['student_number']; ?></td> 
        </tr> 
		 <tr>
            <td>Class : </td>
            <td><?php echo $results[0]['class_name']; ?></td>
            <!--<td><?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){echo '';}else{ ?>House <?php }?></td>
            <td><?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){echo '';}else{ ?>: <?php echo $results[0]['house']; ?></td><?php }?>-->
        </tr>
    </table>
    <?php
        $nurserykg = 0;
        $onetwo = 0;
        if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){$nurserykg = 2;}
        if($results[0]['class_id'] == 1 || $results[0]['class_id'] == 2){$onetwo = 2;}
    ?>

    <table class="main_table" border="1">
        <tr>
		<th <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?> style="color: #000000;">Subject</th>
                <th style="color: #000000;" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?> <?php if($results[0]['class_id'] < 32){?>style="width: 15%" <?php } ?>> <?php if($results[0]['class_id'] < 32){?> Full Marks <?php }else{ ?> Marks <?php } ?> </th>
			<?php 
			if($ct > 0){ 
				if($ct >= 2){ 
			?>
				<th colspan="<?php echo $ct+1; ?>" style="color: #000000;">CT Marks</th>
			<?php }else{ ?>
				<th colspan="<?php echo $ct; ?>" style="color: #000000;">CT Marks</th>
			<?php 
				} 
			}
			?>
			
			<?php 
                        if($results[0]['class_id'] > 31){
			if($subjective > 0){ 
				if($subjective >= 2){ 
			?>
				<th colspan="<?php echo $subjective; ?>" style="color: #000000;">Term Total</th>
			<?php }else{ ?>
				<th colspan="<?php echo $subjective; ?>" style="color: #000000;">Term Total</th>
			<?php 
                        } } }
			?>
            <th style="color: #000000;" width="85" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>> <?php if($results[0]['class_id'] < 32){?> Obtain Marks<?php }else{ ?> Grand Total<br /> <?php } ?> </th>
            <th style="color: #000000;" width="85" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>>Grade Point</th>
            <th style="color: #000000;" width="85" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>>Letter Grade</th>
            <th style="color: #000000;" width="130" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>>Class Highest</th>
            <th style="color: #000000;" width="85" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>>Result Status</th>
            <th style="color: #000000;" width="65" <?php if($results[0]['class_id'] > 31){?>rowspan="2"<?php } ?>>Position</th>
        </tr>
        <tr>            
            <?php if(!empty($subjects['ct1'])): ?><th style="color: #000000;">CT1</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><th style="color: #000000;">CT2</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><th style="color: #000000;">CT3</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><th style="color: #000000;">CT4</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><th style="color: #000000;">CT5</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><th style="color: #000000;">CT6</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><th style="color: #000000;">CT7</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><th style="color: #000000;">CT8</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><th style="color: #000000;">CT9</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><th>CT10</th><?php else: endif; ?>
            <?php if(!empty($subjects['assessment1'])):  ?><th style="color: #000000;">Assessment1</th><?php else: endif; ?>
            <?php if(!empty($subjects['assessment2'])):  ?><th style="color: #000000;">Assessment2</th><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test1'])):  ?><th style="color: #000000;">Oral Test1</th><?php else: endif; ?>
            <?php if(!empty($subjects['oral_test2'])):  ?><th style="color: #000000;">Oral Test2</th><?php else: endif; ?>
            
            <?php if($ct>1){ ?>
                <?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){  ?>
                <th style="color: #000000;">Total</th>
            <?php }else{ ?>
                <th style="color: #000000;">CT<br />(Avg)</th>
            <?php 
                } 
            } 
            ?>  
            <?php if(!empty($subjects['creative']) AND empty($subjects['mcq'])){  ?>
            <?php if($results[0]['class_id'] > 31){?><th style="color: #000000;">Term Exam</th><?php } ?>
            <?php }else{ ?>
            <?php if(!empty($subjects['creative'])):  ?><th style="color: #000000;">Creative</th><?php else: endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['mcq'])):  ?><th style="color: #000000;">MCQ</th><?php else: endif; ?>
            <?php if(!empty($subjects['practical'])):  ?><th style="color: #000000;">Practical</th><?php else: endif; ?>
            <?php if(!empty($subjects['others'])):  ?><th style="color: #000000;">Others</th><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive1'])):  ?><td style="color: #000000;">Descriptive1</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive2'])):  ?><td style="color: #000000;">Descriptive2</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive3'])):  ?><td style="color: #000000;">Descriptive3</td><?php else: endif; ?>
        </tr>
        
        <?php // print_r($results);
        if(!empty($results)):              
            $i=1;
            $j = 0;
            $grand_total = 0;
            foreach ($results[0]['results'] as $result):                
        ?>
        <tr>
            <td align="left" width='200'><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?><?php if(isset($results[0]['optional_sub_id'])  && $results[0]['optional_sub_id'] == $result['subject_id']) {echo ' (Optional)';}else{echo '';} ?></td>
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
            <?php if($results[0]['class_id'] == 6 || $results[0]['class_id'] == 8){  ?>
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
            
            <?php if($results[0]['class_id'] > 31){?><td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td><?php } ?>    
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
            if($results[0]['class_id'] <= 4 || $results[0]['class_id'] == '6' || $results[0]['class_id'] == '8'){
                $add_drawing = 2;
            }else{$add_drawing = 1;}
            ?>
            <?php if(!empty($results[0]['scale_matrix']['title'])): ?><td align="center" rowspan="<?php echo count($results[0]['results']) + $add_drawing; ?>"> <b> <?php if($results[0]['scale_matrix']['weight']<=0){ echo '<span class="result_title">Failed</span>';}else{ echo '<span class="address">Passed</span>'; } ?></b></td> <?php endif; ?>
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
            <td align="center" rowspan="<?php echo count($results[0]['results']) + $add_drawing; ?>"> <?php if(!empty($result['position'])){echo $result['position'];}else{echo '';} ?></td>  
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
            <?php if($results[0]['class_id'] > 31){?>
                <?php if(!empty($subjects['creative'])):  ?><td align="center"></td> <?php endif; ?>
            <?php } ?>
            <?php if(!empty($subjects['mcq'])):  ?><td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['practical'])):  ?> <td align="center"></td><?php endif; ?>
            <?php if(!empty($subjects['others'])):  ?> <td align="center"></td><?php endif; ?>
            <?php // if(!empty($subjects['creative']) AND !empty($subjects['mcq'])){  ?>
            <!--<td align="center"></td>-->
            <?php // } ?>
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
<br>
<button onclick="printthis()"  style="float: right; margin: 0 10px 0;">Print</button>
<script>
    function print_view(url) {
        startload();
        window.open(url, '_blank');
        if (window.focus) {newwindow.focus()}
        removeload()
        return false;	
    }
    function printthis() {
        var printContents = document.getElementById('printview').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }    
</script>    
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