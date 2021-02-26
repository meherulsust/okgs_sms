<?php 
$this->tpl->set_jquery_ui(array('datepicker'));
?>
<form  id="frm-class" name='' method='post' action='<?php echo site_url($active_module.'/edit_class');  ?>' >
<fieldset id="class"><legend>SCHOOL CLASS INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->cform->render(); ?>
    <tr><th class="lbl">
            <label for="class_title">Result Publish</label></th>
        <td class="cln">:</td>
        <td>
            <select class="textfield" id="class_is_result_publish" name="class_is_result_publish" required>
                <option <?php if($class_info['is_result_publish'] == 1){echo 'selected="selected"';}else{} ?> value="1">Publish</option>    
                <option <?php if($class_info['is_result_publish'] == 0){echo 'selected="selected"';}else{} ?> value="0">Unpublish</option>    
            </select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="btn-container">
            <input type="submit" class="btn" value="Submit" name="submit">
            <input type="reset" class="btn" value="Reset" name="button">
        </td>
    </tr>
    
</table>
</fieldset>
	<?php echo $this->cform->render_hidden(); ?>
</form>
<script>
        $("#class_start_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#exam_start_date',
	    dateFormat: 'yy-mm-dd',
	    altFormat: "yy-mm-dd"
	});
	$("#class_end_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#exam_end_date',
	    dateFormat: 'yy-mm-dd',
	    altFormat: "yy-mm-dd"
	});    
</script>