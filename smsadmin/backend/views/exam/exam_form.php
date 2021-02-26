<?php 
$this->tpl->set_jquery_ui(array('datepicker'));
$this->tpl->set_js(array('exam_form','jquery.validate','select-chain'));
?>
<form name='frm-exam' id='frm-exam' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<fieldset id="personal"><legend>EXAM INFORMATION</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
	<?php echo $this->examform->render(); ?>
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