
<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div id="rightnow">
    <h3 class="reallynow"><span>View Details of <?php echo $exam_type ?> Exam. </span> <a href="<?php echo site_url($active_module . '/create') ?>" class="add" title='Create Montyly Exam '>
            Create Monthly Exam</a> <br>
    </h3>
    <table class='view'>
        <tbody>
            <tr><th>Exam Title:</th><td class='txt'><?php echo $title; ?></td>
                <th>Description:</th><td class='txt'><?php echo $description; ?></td>
              </tr>
            <tr><th>Class:</th><td class='txt'><?php echo $class; ?></td>
                <th>Form:</th><td class='txt'><?php echo if_empty($section, 'All Forms'); ?></td></tr>
            <tr> <th>Start Date:</th><td class='txt'><?php echo mysql_to_date($start_date); ?></td>
                 <th>End Date:</th><td class='txt'><?php echo mysql_to_date($end_date); ?></td></tr>
            <tr><th>Created At:</th><td class='txt'><?php echo mysql_to_audit($created_at); ?></td>
                <th>Created By:</th><td class='txt'><?php echo ucfirst('admin'); ?></td></tr>
            <tr><td colspan='4' class='btn-row'>
                    <a href='<?php echo site_url('exam/edit/' . $id) ?>' class='link-btn' title='Edit exam'>Edit</a>
                    <a href='<?php echo site_url('classtest/index/'.$exam_id) ?>' class='link-btn' title='go to list'>Cancel</a>
                </td></tr>
        </tbody>
    </table>
</div>
<div class='clr'></div>
<div id='grid'>
    <?php $this->tpl->load_element('grid_board'); ?>
</div>
<div id='dialog-confirm'><div>Are you sure? You want to delete this item.</div></div>