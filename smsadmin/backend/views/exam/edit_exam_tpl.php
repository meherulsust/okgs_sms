<?php 
$this->tpl->set_jquery_ui(array('datepicker'));
$this->tpl->set_js(array('exam_form','jquery.validate','select-chain'));
?>
<div id="box">
<h3 id="adduser">Edit exam information</h3>
<div id='edit-class'>
<form name='frm-exam' id='frm-exam' method='post' action='<?php echo site_url($active_module.'/amend_result')?>' >
<fieldset id="personal"><legend>EXAM INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->examform->render(); ?>
    <tr><th class="lbl">
            <label for="class_title">Result Publish</label></th>
        <td class="cln">:</td>
        <td>
            <select class="textfield" id="exam_is_result_publish" name="exam_is_result_publish">
                <option <?php if($exam_info['is_result_publish'] == 1){echo 'selected="selected"';}else{} ?> value="1">Publish</option>    
                <option <?php if($exam_info['is_result_publish'] == 0){echo 'selected="selected"';}else{} ?> value="0">Unpublish</option>    

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
<?php echo $this->examform->render_hidden(); ?>
</form>
</div>
</div>