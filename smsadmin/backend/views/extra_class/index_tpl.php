<?php $this->tpl->load_element('flash_message');?>
<?php 
$this->tpl->set_jquery_ui(array('datepicker'));
?>
<div id="box">
    <h3 id="adduser">Assign Extra Class</h3>
    <form id="frm-assign-extra-class" name="frm-assign-extra-class" method="post" action="<?php echo site_url($active_module.'/new_extra_class'); ?>">
        <fieldset id="extra_class">
            <table cellpadding="0" cellspacing ="0" border="0" class="frm-tbl">
                <?php echo $this->secform->render();  ?>
            </table>
        </fieldset>
        <input type="hidden" name="class_time_text" id="class_time_text" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#extraclass_class_date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });   

        $('#extraclass_class_id').selectChain({
            target: $('#extraclass_section_id'),
            value:'title',
            url: SITE_URL+'/json/section',
            type: 'post',
                data:{class_id: 'extraclass_class_id'}
        });
	
	$('#extraclass_class_id').selectChain({
	    target: $('#extraclass_class_time_id'),
	    value:'title',
	    url: SITE_URL+'/json/class_time',
	    type: 'post',
		data:{class_id: 'extraclass_class_id'}
	});
    
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#extraclass_class_time_id').change(function(){
        var class_time_text = $('#extraclass_class_time_id option:selected').text();
        var teacher_id = $('#extraclass_teacher_id').val();
        var class_day_id = $('#extraclass_class_day_id').val();
        
        if(class_day_id == ''){
            alert('Select Class Day.');
            $('#extraclass_class_time_id').val('');
            return false;
        }
        if(teacher_id == ''){
            alert('Select Teacher.');
            $('#extraclass_class_time_id').val('');
            return false;
        }
        $.ajax({
            url: '<?php echo site_url(); ?>/extra_class/check_duplicate_class',
            dataType: 'json',
            type: 'post',
            data: {'teacher_id': teacher_id, 'class_day_id': class_day_id, 'class_time_text': class_time_text},
            success: function(data){
                if(data > 0){
                    alert('The Teacher is busy at the time you are trying to allocate.');
                    $('#submit_btn').prop('disabled', true);
                }else{
                    $('#submit_btn').prop('disabled', false);
                }
            }
        });
        
    });
    
    //Enable submit button
    $('#reset_btn').click(function(){
        $('#submit_btn').prop('disabled', false);
    });
});
</script>
