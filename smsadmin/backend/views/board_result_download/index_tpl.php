<?php $this->tpl->load_element('flash_message');  ?>
<div id="box">
    <h3 class='grid_title_bar'>Uploaded Results
        <a href="<?php echo site_url('board_result_download/add_new_result'); ?>" class="add">Upload Result</a>
    </h3>
    <table width='100%'>
	 <thead>
            <tr>
               <th class="first">#</th>
               <th class="first">Examination</th>
               <th class="first">Description</th>
               <th class="first">Year</th>
               <th class="first">Actions</th>
            </tr>
         </thead>
         <tbody>
        <?php
            if(!empty($results)){
                $i = 1;
                foreach ($results as $result){
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                    <a href="<?php echo base_url(); ?>uploads/board_result/<?php echo $result['file_name'];  ?>" target="_new" download><?php echo $result['exam_name'];  ?></a>
                </td>
                <td>  <?php echo $result['description'];  ?> </td>
                <td>  <?php echo $result['year'];  ?> </td>
                <td>
                    <a href="<?php echo site_url('board_result_download/edit') ?>/<?php echo $result['id'];  ?>" title="Edit this record" class="edit_actn"><img src="<?php echo base_url();  ?>/img/actn_edit.png" alt="Edit" class="edit-icon"></a>
                    <a onclick="return confirm('Are you sure you want delete this record');" href="<?php echo site_url('board_result_download/delete') ?>/<?php echo $result['id'];  ?>" title="Delete this record" class="del_actn"><img src="<?php echo base_url();  ?>/img/actn_del.png" alt="Delete" class="del-icon"></a>
                    <a href="<?php echo base_url(); ?>uploads/board_result/<?php echo $result['file_name']; ?>" title="Download Result" class=""><img src="<?php echo base_url();  ?>/img/actn_certificate.png" alt="Delete" class=""></a>
                </td>
            </tr>
        <?php
            $i++;
            }}else{
        ?>
            <tr><td colspan='5' class='no-record'>No record is found.</td></tr>
            <?php  } ?>
         </tbody>
         
    </table>
</div>
