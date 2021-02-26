<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$tabulationsheet_filename);
    header("Pragma: no-cache");
    header("Expires: 0");	
?>
            <h3 id="add">Tabulation Sheet</h3>
            <h2><?php echo $school_info['name'];?></h2>
            <span><b><?php echo $exam; ?></b></span><br/>
            <span><b>Class :</b><?php echo $results[0]['class_name']; ?></span>
            <span><b>Section :</b><?php if(!empty($results[0]['section_title'])) {echo $results[0]['section_title'];}else{echo '';} ?></span>
            <br/>
            <?php   
            if(!empty($results)){
//                echo '<pre>';
//                print_r($results);
                $onetwo = 0;
                if($class_id == 1 || $class_id == 2){$onetwo = 2;}
            ?>
            <table border="1" width="100%">
                <tr>
                    <th rowspan = "2">#</th>
                    <th rowspan = "2">ROLL NO.</th>
                    <th rowspan = "2">NAME OF THE STUDENT</th>
                    <?php
                    if(!empty($subjects)){
                        foreach ($subjects as $course){
                    ?>
                    <th colspan="<?php echo count($course['exam_types']) + 2; ?>">
                        <?php if(!empty($course)){echo $course['subject'];}else{echo '';} ?>
                    </th>
                    <?php }} ?>    
                    <th rowspan = "2">Total</th>
                    <th style="color: #0072BC;" rowspan = "2">LG & GPA</th>
                    <th rowspan = "2">Position</th>
                </tr>
                <tr>
                    <?php
                    if(!empty($subjects)){
                        foreach ($subjects as $course){
                            foreach($course['exam_types'] as $key=>$exam_types ){
                    ?>
                    <th><?php echo strtoupper($exam_types); ?></th>     
                        
                    <?php }
                    ?>
                        <th>TOTAL</th>
                        <th>LATTER GRADE</th>
                    <?php
                    }}?>
                </tr>
                
                <?php
                    if(!empty($results)){
                        $x = 1;
                        foreach ($results as $result){
                ?>
                <tr>
                    <td><?php echo $x;  ?></td>
                    <td style="text-align: center;"><?php if(!empty($result)){ echo $result['class_roll'];}else {echo '';} ?></td>
                    <td><?php if(!empty($result)){ echo $result['student_name'];}else {echo '';} ?></td>
                    <?php   
                        $total = 0;
                    ?>
                    <?php
                     if(!empty($subjects)){
                         foreach ($subjects as $course){ 
                             $grand_tot = 0;
                             foreach($course['exam_types'] as $key=>$exam_types ){
                     ?>
                         <td style="text-align: center;">
                            <?php 
                            $half_yearly_lg = '';
                            foreach ($result['results'] as $grade){
                                if($course['subject_id'] == $grade['subject_id']){ 
                                    echo $grade[$key];
                                    $grand_tot += $grade[$key];
                                    $half_yearly_lg = $grade['half_yearly_lg'];
                                }else{echo '';} 
                            }
                            ?>
                         </td>
                     <?php } ?>
                         <td>
                            <?php   
                            foreach ($result['results'] as $grade){
                                if($course['subject_id'] == $grade['subject_id']){ echo $grade['half_yearly_grand_total'];}else{echo '';} 
                            }
                            ?>
                         </td>
                         <td align="center">
                             <?php echo $half_yearly_lg; ?>
                         </td>
                     <?php
                     }}?>
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
                    if(!empty($result['scale_matrix']['title']) && $result['scale_matrix']['title'] == 'F')
                    {$color = 'color: #CC0000;';}else{$color = 'color: #0072BC;';}
                    
                    ?>
                    <td align="center"><?php if(!empty($result)){ echo $result['total_mks_half_yearly'];}else {echo '';} ?></td>
                    <td style="<?php if(isset($color)){ echo $color;}else{echo '';} ?>" align="center"><?php if(!empty($result)){ echo $result['scale_matrix']['title'].'<br />'. sprintf('%.2f',$result['scale_matrix']['weight']);}else {echo '';} ?></td>
                    <td align="center"><?php  if($onetwo == 2){echo '';}else{ echo $result['position'];} ?></td>
                </tr>
                <?php 
                    $x++;
                    }} 
                ?>
            </table>
            <?php
            }else{
        ?>
    <table>
        <tr>
            <td align="center"><b>No Record found!</b></td>
        </tr>
    </table>
        <?php            
            }
        ?>