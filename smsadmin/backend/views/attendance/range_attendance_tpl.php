<div id="box">
    <h3 class='grid_title_bar'>Student Attendance List</h3>
    <?php if(!empty($stdinfo)){  ?>
    <table width='100%'>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Student Number</th>
                <th>Class</th>
                <th>Form</th>
                <th>Class Roll</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Working Days</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $x = 1;
                foreach ($stdinfo as $info){                    
            ?>
            <tr>
                <td align="center"><?php echo $x; ?></td>
                <td><?php if(!empty($info['student_name'])){ echo $info['student_name'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['number'])){ echo $info['number'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['class_name'])){ echo $info['class_name'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['section_title'])){ echo $info['section_title'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['class_roll'])){ echo $info['class_roll'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['date_from'])){ echo $info['date_from'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['date_to'])){ echo $info['date_to'];}else{echo '';} ?></td>
                <td align="center"><?php if(!empty($info['present'])){ echo $info['present'];}else{echo '0';} ?></td>
                <td align="center"><?php if(!empty($info['absent'])){ echo $info['absent'];}else{echo '0';} ?></td>
                <td align="center"><?php if(!empty($info['working_days'])){ echo $info['working_days'];}else{echo '0';} ?></td>
            </tr>
            <?php $x++; } ?>
        </tbody>
    </table>
    <?php }else{ ?>
    <table>
        <tr>
            <td>No Record Found!</td>
        </tr>
    </table>
    <?php } ?>
</div>