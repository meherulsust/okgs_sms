<?php $this->tpl->load_element('flash_message');?>
<?php if($this->pform->is_new() && count($photos)):?>
<div id="box">
<h3 id="photo">Student Photos</h3>
<table id='photo-list'>
<tr><th class='first'>Photo</th><th>Create Date</th><th>Update Date</th><th>Created By</th><th>Action</th></tr>
<?php foreach($photos as $photo):?>
<tr><td class='first'><img src='<?php echo base_url().'uploads/std_photo/'.$photo['file_name'] ;?>' width='100' height='100' border='0' /></td>
<td><?php echo $photo['create_date'] ?></td><td><?php echo $photo['update_date'] ?></td><td>Admin</td>
<td class='action last'>
  <a href='<?php echo site_url('student/photo/'.$photo['student_id'].'/'.$photo['id'])?>' title='Change photo' class='edit_actn'><img src='<?php echo $image_url ?>a_edit.gif'  alt='edit' class='edit-icon' /></a>
  <a href='<?php echo site_url('student/delphoto/'.$photo['student_id'].'/'.$photo['id'])?>' title='Remove photo' class='del_actn'><img src='<?php echo $image_url ?>a_del.gif'  alt='delete' class='delete-icon' /></a>
</td></tr>
<?php endforeach ?>
</table>
</div>
<?php endif ?>
<div id='std-photo'>
<?php $this->load->view('student/photo_form') ?>
</div>
