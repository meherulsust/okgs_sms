<div id="rightnow">
    <h3 class="reallynow"><span>Formula details</span> <a href="<?php echo site_url('publish_result/create') ?>" class="add" title='Create new book'></a> <br>
    </h3>
    <table class='view'>
        <tbody>
            <tr><th>Class</th><td class='cln'>:</td><td class='txt'><?php echo $class_title; ?></td></tr>
            <tr><th>Subject</th><td class='cln'>:</td><td class='txt'><?php echo ucfirst(strtolower($course_title)); ?></td></tr>
            <tr><td colspan='3' class='btn-row'>
                    <a href='<?php echo site_url($active_module . '/edit/' . $id) ?>' class='link-btn' title='Edit this record'>Edit</a>
                    <a href='<?php echo site_url($active_module . '/index') ?>' class='link-btn' title='go to list'>Cancel</a></td></tr>
        </tbody>
    </table>
</div>