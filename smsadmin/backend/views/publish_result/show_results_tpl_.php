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
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr{
    width:100%;      
}
.main_table tr th{
    font-size:11px;
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr td{
    font-size:12px;
    padding:4px;
    border:1px solid #000;
    border-collapse: collapse;
}

.head_table{
    width:100%;  
    border:1px solid #fff;
    border-collapse: collapse;
    margin-bottom:10px;
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
    ?>
    <?php
    foreach ($results as $res):       
    ?>    
    <div style="height:1200px;">
    <table class="head_table">
         <tr>
             <td align="center"><div class="school_header">Rajshahi Cantonment Public School & College</div></td>
         </tr>
         <tr>
             <td align="center"><div class="school_header_info">Rajshahi Cantonment, Rajshahi</div></td>
        </tr>
        <tr>
            <td align="center"><div class="school_header_info">Progress Report I</div></td>
         </tr>
     </table>
    
    <table class="head_table">        
        <tr>
            <td width="10%">Name : </td>
            <td width="60%"><?php  echo $res['student_name']; ?></td>
            <td width="10%">Section:</td>
            <td width="20%"><?php echo $res['section_title']; ?></td>
        </tr>
        <tr>
            <td>Class : </td>
            <td><?php echo $res['class_name']; ?></td>
            <td>House : </td>
            <td></td>
        </tr>
        <tr>
            <td>Roll : </td>            
            <td><?php echo $res['class_roll']; ?></td>  
            <td>ID : </td>            
            <td><?php echo $res['student_id']; ?></td> 
        </tr>                       
    </table>
    
    <table class="main_table">
        <tr>
            <th colspan="<?php if(!empty($num_exam_types)): echo $term_total_row_span = $num_exam_types['1'] + 3; else: endif; ?>">CT Marks</th>
            <th colspan="<?php if(!empty($num_exam_types)): echo $term_total_row_span = $num_exam_types['2'] + 1; else: endif; ?>">Term Total(100)</th>
            <th rowspan="2">Grand Total (GT)<br />(20%+80%)</th>
            <th rowspan="2">Grade Point <br /> (GP)</th>
            <th rowspan="2">Later Grade <br />(LG)</th>
            <th rowspan="2">Class Highest <br /> (CH)</th>
            <?php if($exam_id == '3'): ?><td colspan="6">Final Result</th> <?php endif;  ?>
            <th rowspan="2">Total <br /> Mks</th>
            <th rowspan="2">Result Status</th>
        </tr>
        <tr>
            <th>Sub</th>
            <th>Mks</th>
            <!--<th>Pass</th>-->
            <?php if(!empty($subjects['ct1'])): ?><th>CT1</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct2'])):  ?><th>CT2</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct3'])):  ?><th>CT3</th><?php else: endif; ?>
            <?php if(!empty($subjects['ct4'])):  ?><td>CT4</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct5'])):  ?><td>CT5</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct6'])):  ?><td>CT6</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct7'])):  ?><td>CT7</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct8'])):  ?><td>CT8</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct9'])):  ?><td>CT9</td><?php else: endif; ?>
            <?php if(!empty($subjects['ct10'])):  ?><td>CT10</td><?php else: endif; ?>
            <th>CT<br />(Avg)</th>
            <?php if(!empty($subjects['creative'])):  ?><th>Creative</th><?php else: endif; ?>
            <?php if(!empty($subjects['mcq'])):  ?><td>MCQ</td><?php else: endif; ?>
            <?php if(!empty($subjects['practical'])):  ?><td>Practical</td><?php else: endif; ?>
            <?php if(!empty($subjects['others'])):  ?><td>Others</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive1'])):  ?><td>Descriptive1</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive2'])):  ?><td>Descriptive2</td><?php else: endif; ?>
            <?php if(!empty($subjects['descriptive3'])):  ?><td>Descriptive3</td><?php else: endif; ?>
            
            <th>Total</th>
            <?php if($exam_id == '3'): ?>
                <td>HY <br />Mks</td>
                <td>Yearly <br />Mks</td>
                <td>(HY+Y)<br />Avg</td>
                <td>GP</td>
                <td>LG</td>
                <td>CH<br />Avg</td>
            <?php else: endif; ?>
        </tr>
        <?php // print_r($results);
        if(!empty($results)):              
            $i=1;
            foreach ($res['results'] as $result):
        ?>
        <tr>
            <td align="center"><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td align="center"><?php if(!empty($result['full_mark'])): echo $result['full_mark']; else: echo '';  endif; ?></td>
<!--            <td align="center">50%</td>-->
            <?php if(!empty($result['ct1'])): ?><td align="center"><?php echo $result['ct1']; else: echo ''; ?></td><?php endif; ?>
            <?php if(!empty($result['ct2'])): ?><td align="center"><?php echo $result['ct2']; else: echo ''; ?></td><?php endif; ?>
            <td align="center"><?php echo $ct_avg = ceil(($result['ct1']+$result['ct2']+$result['ct3']+$result['ct4']+$result['ct5']+$result['ct6']+$result['ct7']+$result['ct8']+$result['ct9']+$result['ct10'])/$num_exam_types['1']); ?></td>
            <?php if(!empty($result['creative'])): ?><td align="center"><?php echo $result['creative'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['mcq'])): ?><td align="center"><?php echo $result['mcq'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['practical'])): ?><td align="center"><?php echo $result['practical'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['others'])): ?><td align="center"><?php echo $result['others'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['descriptive1'])): ?><td align="center"><?php echo $result['descriptive1'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['descriptive2'])): ?><td align="center"><?php echo $result['descriptive2'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['descriptive3'])): ?><td align="center"><?php echo $result['descriptive3'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['half_yearly_total'])): ?><td align="center"><?php echo $result['half_yearly_total'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['yearly_total'])): ?><td align="center"><?php echo $result['yearly_total'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['half_yearly_grand_total'])): ?><td align="center"><?php echo $result['half_yearly_grand_total'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['yearly_grand_total'])): ?><td align="center"><?php echo $result['yearly_grand_total'];  ?></td> <?php endif; ?>
            <td align="center"><?php echo $result['half_yearly_gp'];  ?></td>
            <?php if(!empty($result['yearly_gp']) && $result['yearly_gp'] > 0): ?><td align="center"><?php echo $result['yearly_gp'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['half_yearly_lg'])): ?><td align="center"><?php echo $result['half_yearly_lg'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['yearly_lg'])): ?><td align="center"><?php echo $result['yearly_lg'];  ?></td> <?php endif; ?>
            <?php if(!empty($result['hmark']['half_yearly_class_highest'])): ?><td align="center"><?php echo $result['hmark']['half_yearly_class_highest'];  ?></td> <?php endif; ?>
            <?php if($exam_id == '3'): ?>
            <td align="center"><?php if(!empty($result['mid_term_mks'])): ?> <?php echo $result['mid_term_mks'];  ?> <?php endif; ?></td>
            <td align="center"><?php if(!empty($result['yearly_grand_total'])): ?><?php echo $result['yearly_grand_total'];  ?> <?php endif; ?></td>
            <td align="center"><?php echo $final_avg = ceil(($result['mid_term_mks'] + $result['yearly_grand_total'])/2);   ?></td>
            <td align="center"><?php if($final_avg > 0): ?><?php echo $result['final_gp'];  ?> <?php endif; ?></td>
            <td align="center"><?php if(!empty($result['final_lg'])): ?><?php echo $result['final_lg'];  ?> <?php endif; ?></td>
            <td align="center"></td>
            <?php endif; ?>
            <?php
            if($i==1)
            { 
            ?>
            <?php if(!empty($res['total_mks']['total_mks_half_yearly'])): ?><td align="center" rowspan="6"> <?php echo $res['total_mks']['total_mks_half_yearly'];  ?></td> <?php endif; ?>
            <?php if(!empty($res['scale_matrix']['title'])): ?><td align="center" rowspan="6"> <?php echo $res['scale_matrix']['title'];  ?><br /><?php echo $res['scale_matrix']['weight'];  ?></td> <?php endif; ?>
            <?php } ?>
        </tr>
        <?php   
        $i++;
            endforeach;
        endif;
        ?>
    </table>
    <br/>
   <table class="main_table">
	<tr>
		<th rowspan="2" width="20%">
		Notes
		</th>
		<th colspan="2" width="213">
		Half Yearly Exam
		</th>
		<th colspan="3" width="319">
		Signature
		</th>
	</tr>
	<tr>
		<th width="20%">
		Other Info
		</th>
		<th width="10%">
		Statement
		</th>
		<th width="30%">
		Class Teacher
		</th>
		<th width="10%">
		Guardian
		</th>
		<th width="10%">
		Principal
		</th>
	</tr>
	<tr>
            <td rowspan="6">
                *GP - GRade Point <br />
                *LG - Later Grade <br />
                *SM - Subject Marks <br />
                *GT - Grade Point <br />
                *BGS - Bangladesh & Global Studies <br />
                *Avg - Average
            </td>
		<td>Total Students</td>
		<td></td>
                <td rowspan="6"></td>
		<td rowspan="6"></td>
		<td rowspan="6"></td>
	</tr>
	<tr>
		<td>Working Days</td>
		<td></td>		
	</tr>
	<tr>
		<td>Attendance</td>
		<td></td>
	</tr>
	<tr>
		<td>Discipline</td>
		<td></td>
	</tr>
	<tr>
		<td>Cleanliness</td>
		<td></td>
	</tr>
	<tr>
		<td>Extra Curricula Activities</td>
		<td></td>
	</tr>
</table>
</div>    
<?php 
endforeach;   
?>
</body>
</html>


    