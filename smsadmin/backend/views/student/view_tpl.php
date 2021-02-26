<div id="box">
    <?php $this->tpl->load_element('flash_message'); ?>
    <h3>Personal information of <i><?php echo $first_name . ' ' . $last_name ?></i></h3>
    <table width='800' border='0' cellspacing='0' cellpadding='0' id='profile'>
        <tr>
            <th>Full Name:</th>
            <td><?php echo $full_name ?></td>
            <th>Father's Name:</th>
            <td><?php echo $father_name ?></td>
            <th>Mother's:</th>
            <td><?php echo ucfirst($mother_name) ?></td>
        </tr>
        <tr>
            <th>Naionality:</th>
            <td><?php echo $nationality ?></td>
            <th>Student Number:</th>
            <td><?php echo $student_number ?></td>
            <th>Date of Birth:</th>
            <td><?php echo $dob; ?></td>
        </tr>

        <tr>
            <th>Gender:</th>
            <td><?php echo ucfirst($gender) ?></td>
            <th>Class:</th>
            <td><?php echo $class ?></td>
            <th>Form:</th>
            <td><?php echo $section ?></td>
        </tr>
        <tr>
             <th>Contact Number:</th>
            <td><?php echo $mobile ?></td>
            <th>Religion:</th>
            <td><?php echo $religion; ?></td>
            <th>Tribe:</th>
            <td><?php echo $tribe; ?></td>
        </tr>
         <tr>
            <th>Status:</th>
            <td><?php echo $status; ?></td>
            <th>Created At:</th>
            <td><?php echo $created_on; ?></td>
            <th>Created By:</th>
            <td><?php echo $created_by; ?></td>
        </tr>
        <tr>
            <th>Blood Group:</th>
            <td><?php echo $blood_group; ?></td>
			<th>Comments:</th>
            <td colspan='3'><?php echo $comments ?></td>
        </tr>
    </table>
    <?php if ($photo_id): ?>
        <img class='border' id='std-img' src='<?php echo base_url() . 'uploads/std_photo/' . $file_name ?>'
             width='100' height='100' style='float: right' />
         <?php else: ?>
        <img class='border' id='std-img' src='<?php echo $image_url ?>nophoto.jpg'
             width='100' height='100' style='float: right' />
         <?php endif ?>	
    <div class='clr'></div>
    <div id='mtab'>
        <ul>
            <li><a href="<?php echo site_url('student/personal/' . $id . '/' . $personal_details_id . '/view') ?>" title='Personal Information'>Personal Info</a></li>
            <li><a href="<?php echo site_url('student/guardian/' . $id . '/father/' . $father_guardian_id) ?>" title='Father'>Father's Info</a></li>
            <li><a href="<?php echo site_url('student/guardian/' . $id . '/mother/' . $mother_guardian_id) ?>" title='Mother'>Mother's Info</a></li>
            <li><a href="<?php echo site_url('student/guardian/' . $id . '/guardian/' . $local_guardian_id) ?>" title="Local Guardian">Guardian</a></li>
            <li><a href="<?php echo site_url('student/address/' . $id . '/permanent/' . $permanent_address_id) ?>" title='Address'>Permanent Address</a></li>
            <li><a href="<?php echo site_url('student/address/' . $id . '/present/' . $present_address_id) ?>" title='Address'>Present Address</a></li>
            <li><a href="<?php echo site_url('student/photo/' . $id) ?>" title="Picture">Photo</a></li>
            <li><a href="<?php echo site_url('student/sstatus/' . $id) ?>" title="Status">Status</a></li>
            <li><a href="<?php echo site_url('student/admission/' . $id) ?>" title="Admission">Admission</a></li>

        </ul>
    </div>

</div>
<script language='javascript'>
    var stab;
    $(document).ready(function(){
        stab = $("#mtab" ).tabs({
            select: function(event, ui) { $("#mtab").mask("Loading...");},
            load:   function(event, ui) {  $("#mtab").unmask(); },
            cache: false,
            ajaxOptions: {
                cache: false,
                error: function( xhr, status, index, anchor ) {
                    $( anchor.hash ).html("Couldn't load this tab. Please inform system administrator. ");
                }
            }
        }); 
    });

</script>
