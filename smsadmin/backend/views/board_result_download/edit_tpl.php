<?php $this->tpl->load_element('flash_message');  ?>
<div id="box">
    <h3 id="adduser">Upload Board Exam</h3>
    <form id="frm-upload-boardexam" name="frm-upload-boardexam" method="post" action="<?php echo site_url($active_module.'/add_new_result'); ?>"  enctype='multipart/form-data' >
        <fieldset id="extra_class">
            <table cellpadding="0" cellspacing ="0" border="0" class="frm-tbl">
                <?php echo $this->examdetailsform->render();  ?>
            </table>
        </fieldset>
        <?php echo $this->examdetailsform->render_hidden();  ?>
    </form>
</div>