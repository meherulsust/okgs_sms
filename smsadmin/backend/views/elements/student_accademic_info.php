<div class="accademic-info">
<h3>Personal information of <i><?php echo $std_info['first_name'] . ' ' . $std_info['last_name'] ?></i></h3>
    <table width='800' border='0' cellspacing='0' cellpadding='0' id='profile'>
        <tr>
            <th>Full Name:</th>
            <td><?php echo $std_info['first_name'] . ' ' . $std_info['last_name'] ?></td>
            <th>Student Number:</th>
            <td><?php echo $std_info['student_number'] ?></td>
            <th>Class:</th>
            <td><?php echo $std_info['class'] ?></td>
        </tr>
        <tr>
            <th>Form:</th>
            <td><?php echo $std_info['section'] ?></td>
            <th>Class Roll:</th>
            <td><?php  echo $std_info['class_roll'] ?></td>
            <th>Contact Number:</th>
            <td><?php echo $std_info['mobile'] ?></td>
        </tr>
    </table>
    <?php if ($std_info['photo_id']): ?>
        <img class='border' id='std-img' src='<?php echo base_url() . 'uploads/std_photo/' . $std_info['file_name'] ?>'
             width='100' height='100' style='float: right' />
         <?php else: ?>
        <img class='border' id='std-img' src='<?php echo $image_url ?>nophoto.jpg'
             width='100' height='100' style='float: right' />
         <?php endif ?>	
 </div>       
    <div class='clr'></div>