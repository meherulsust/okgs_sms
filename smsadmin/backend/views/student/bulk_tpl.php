<div id="box">
<h3 id="adduser">Upload student information in bulk</h3>
<div id='bulk-upload'>
    <?php $this->tpl->load_element('flash_message');?>
    <form  id="frm-bulk" name='bulk-upload' method='POST' action='<?php echo site_url($active_module.'/bulk');  ?>' enctype="multipart/form-data">
<fieldset id="personal"><legend>UPLOAD STUDENT INFORMATION EXCEL FILE</legend>
<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
    
    <tr>
        <th class="lbl"><label for="upload_file">Upload File</label></th>
        <td class="cln">:</td><td><input name="file_excel"  id="upload_file"  type="file" /><span class="finfo">(Maximum File Size 10 MB)</span></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td><td class="btn-container"><input type="submit" name="upload_btn" value="Upload" class="btn"/></td> </tr>
</table>
</fieldset>
</form>
</div>
</div>