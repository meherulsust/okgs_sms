<?php if($has_record): ?>
<table id="std-info-modal">
    <tr>
        <th>Student Name</th><th class="cln">:</th><td><?php echo ucwords(strtolower($first_name.' '.$last_name)); ?></td>
        <td colspan="3" rowspan="6" align="right">           
            <?php if ($photo_id): ?>
                <img  src='<?php echo base_url() . 'uploads/' . $file_name ?>' width='100' height='100' class="border" />
                  <?php else: ?>
                <img  src='<?php echo $image_url ?>nophoto.jpg' width='100' height='100' class="border" />
            <?php endif ?>	
        </td>
    </tr>
     <tr>
         <th>Student Number</th><th class="cln">:</th><td><?php echo $student_number ?></td>
    </tr>
   
    <tr>
        <th>Student Status</th><th class="cln">:</th><td><?php echo $status ?></td>
    </tr>
     <tr>
        <th>Gender</th><th class="cln">:</th><td><?php echo ucfirst(strtolower($gender)) ?></td>
    </tr>
    <tr>
        <th>Date of Birth</th><th class="cln">:</th><td><?php echo $dob ?></td>
    </tr>
     <tr>
        <th>Father's Name</th><th class="cln">:</th><td><?php  echo ucwords(strtolower($father_name1.' '.$father_name2)); ?></td>
    </tr>
    <tr>
       <th>Class Name</th><th class="cln">:</th><td><?php echo $class ?></td>
       <th>Form</th><th class="cln">:</th><td><?php echo $section ?></td>
    </tr>
    <tr>
        <th>Class roll</th><th class="cln">:</th><td><?php echo $class_roll ?></td>
       <th>Mobile number</th><th class="cln">:</th><td><?php echo $mobile ?></td>
    </tr>
     <tr>
        <th>Created At</th><th class="cln">:</th><td><?php echo $created_on ?></td>
       <th>Created By</th><th class="cln">:</th><td><?php echo $created_by ?></td>
    </tr>
    <tr>
        <th>Comments</th><th>:</th><td colspan="4"><?php echo $comments ?></td>
    </tr>
</table>
<?php else: ?>
 <ul class="system_messages"><li class="yellow"><span class="ico"></span><strong class="system_title"> No information is found.</strong></li></ul> 
<?php endif; ?>

