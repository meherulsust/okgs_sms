<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>    
</ul>
<?php    
    $id = $this->input->get('course_id');
?>            
<div id="box">
    <h3 id="adduser">Configure Subjects</h3>
    <form name='frm-configure-subjects' id='frm-configure-subjects' method='post' action='<?php echo site_url($active_module . '/save') ?>' >
        <table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
            <?php echo $this->configure_subjectsform->render(); ?>
        </table>
        <?php   
        if(!empty($id)){
        ?>
        <input type="hidden" name="course_id" value="<?php echo $id; ?>" />
        <?php  } ?>
    </form>
</div>
<?php
    $uri_class = $this->input->get('class');
    if(!empty($uri_class)):
?> 
<script>   
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    
  $(window).load(function(){
            var class_id = getUrlParameter('class');
            var course = getUrlParameter('course');
            $('#configure_subjects_class_id').val(class_id);
            $('#configure_subjects_course_title_id').val(course);
   });      
</script>   
<?php 
endif;
?>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo base_url(); ?>index.php/assign_subjects";
       }); 
    });
</script>