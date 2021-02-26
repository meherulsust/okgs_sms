<style type="text/css">
.main_table{
    /*width:100%;*/  
    /*margin-top:15px;*/
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr{
/*    width:100%;      */
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
    border: 0px !important;    
} 
#printview {
  overflow-x: auto;
  overflow-y: hidden;
}
</style>
<div id="box"><h3 id="add">Tabulation Sheet</h3>
    <div id="container">
        <div id="content">
            <?php   
            if(!empty($results)){
//                echo '<pre>';
//                print_r($results);
                $onetwo = 0;
                if($class_id == 1 || $class_id == 2){$onetwo = 2;}
            ?>
            <div id="printview">
                <table border="0" class="head_table">
                <tr>
                    <td style="text-align: center; font-size: 14px; font-weight: bold;"><?php echo $school_info['name']; ?></td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 14px; font-weight: bold;"><?php echo $exam;  ?></td>
                </tr>
            </table>
            <br />
            <table border="0" class="head_table">        
                <tr>
                    <td style="text-align: center; font-size: 14px;"><b>Class:</b></td>
                    <td width="40%" style="font-size: 15px;"><?php echo $results[0]['class_name']; ?></td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><b>Form:</b></td>
                    <td style="font-size: 14px;"><?php if(!empty($results[0]['section_title'])) {echo $results[0]['section_title'];}else{echo '';} ?></td>
                </tr>
            </table>
            <br />    
            
            <table class="main_table">
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
                    <td><?php if(!empty($result)){ echo $result['class_roll'];}else {echo '';} ?></td>
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
                         <td>
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
            </div>
            <br />
            <table>
                <tr>
                    <td align="center">
                        <form action="<?php echo site_url($active_module.'/download_tabulationsheet'); ?>" name="generate_tabulation_download" id="generate_tabulation_download" method="post">
                            <button type="submit" style="float: right; margin: 0 10px 0;">Download Record</button>
                            <input type="hidden" name="class_id" id="class_id" value="<?php echo $class_details['class_id']; ?>" />
                            <input type="hidden" name="section_id" id="section_id" value="<?php echo $class_details['section_id']; ?>" />
                            <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $class_details['exam_id']; ?>" />
                        </form>
                    </td>
                </tr>
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
        </div>
    </div>
</div>