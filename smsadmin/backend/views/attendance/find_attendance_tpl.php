<?php 
$this->tpl->set_js('select-chain');
$this->tpl->set_jquery_ui(array('datepicker'));
?>
<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 class='grid_title_bar'>Student Attendance</h3>
<form name='frm-studentattendance' id='frm-studentattendance' method='post' action='<?php echo site_url($active_module.'/attendance_info'); ?>' >
    <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <?php echo $this->student_attendanceform->render();  ?>
    </table>
</form>    
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#stdattendance_class_id').selectChain({            
	    target: $('#stdattendance_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'stdattendance_class_id'}
	});
        $("#stdattendance_date_from, #stdattendance_date_to" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-02:+01",
            dateFormat: 'yy-mm-dd'
        });
    });
</script>