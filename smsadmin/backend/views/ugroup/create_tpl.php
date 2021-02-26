<div id="box">
    <h3 id="add"> <?php if($this->usergroupform->is_new()): ?> Create User Group <?php else: ?>
        Edit User Group
        <?php endif; ?>
    </h3>
<?php $this->load->view('ugroup/user_group_form') ?>
</div>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo site_url('ugroup/index'); ?>";
       }); 
    });
</script>
