<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div id="rightnow">
    <h3 class="reallynow"><span>View Details of <?php echo $exam_type ?> Exam  </span> <a href="<?php echo site_url($active_module . '/create') ?>" class="add" title='Create New Exam '>
            New Exam</a> <br>
    </h3>
    <table class='view'>
        <tbody>
            <tr><th>Exam Title:</th><td class='txt'><?php echo $exam; ?></td>
                <th>Exam Fee:</th><td class='txt'><?php echo $fee; ?></td></tr>
            <tr><th>Class:</th><td class='txt'><?php echo $class; ?></td>
                <th>Form:</th><td class='txt'><?php echo if_empty($section, 'All Forms'); ?></td></tr>

            <tr><th>Description:</th><td class='txt'><?php echo $description; ?></td>
                <th>Status:</th><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
            <tr><th>Created At:</th><td class='txt'><?php echo mysql_to_audit($created_at); ?></td>
                <th>Created By:</th><td class='txt'><?php echo ucfirst('admin'); ?></td></tr>
            <tr><td colspan='4' class='btn-row'>
                    <a href='<?php echo site_url($active_module . '/edit/' . $id) ?>' class='link-btn' title='Edit this record'>Edit</a>
                    <a href='<?php echo site_url($active_module . '/register/' . $id) ?>' class='link-btn' title='Register all Students for this exam' id='register'>Register All Students</a>
                    <?php if ($is_final == 'YES'): ?>
                        <a href='<?php echo site_url($active_module . '/promote/' . $id) ?>' class='link-btn' title='Promote all registered students to next class' id='promote'>Promote To Next Class</a>
                    <?php endif ?>
                    <a href='<?php echo site_url($active_module . '/index') ?>' class='link-btn' title='go to list'>Cancel</a>
                </td></tr>
        </tbody>
    </table>
</div>
<div class='clr'></div>
<div id='grid'>
    <?php $this->tpl->load_element('grid_board'); ?>
</div>