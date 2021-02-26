<div id="rightnow">
    <h3 class="reallynow"><span>Syllabus details</span> <a href="<?php echo site_url($active_module . '/create') ?>" class="add" title='Create new syllabus'>Add
            New Syllabus</a> <br>
    </h3>
    <table class='view'>
        <tbody>
            <tr><th>Syllabus Title:</th><td class='txt'><?php echo $title; ?></td>
                <th>Total Marks:</th><td class='txt'><?php echo $total_marks; ?></td></tr>
            <tr><th>Class:</th><td class='txt'><?php echo $class; ?></td>
                <th>Form:</th><td class='txt'><?php echo $section; ?></td></tr>

            <tr><th>Description:</th><td class='txt'><?php echo $description; ?></td>
                <th>Status:</th><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
            <tr><th>Created At:</th><td class='txt'><?php echo mysql_to_audit($created_at); ?></td>
                <th>Created By:</th><td class='txt'><?php echo ucfirst('admin'); ?></td></tr>
            <tr><td colspan='4' class='btn-row'>
                    <a href='<?php echo site_url($active_module . '/edit/' . $id) ?>' class='link-btn' title='Edit this record'>Edit</a>
                    <a href='<?php echo site_url($active_module . '/setup/' . $id) ?>' class='link-btn' title='Set Up syllabus'>Configure</a>
                    <a href='<?php echo site_url($active_module . '/index') ?>' class='link-btn' title='go to list'>Cancel</a>
                </td></tr>
        </tbody>
    </table>
    <div class='clr'></div>
    <div id='stab'>
        <ul>
            <li><a href="<?php echo site_url('sylabussetup/attribute/' . $id) ?>" title='Attribute'>Attribute</a></li>
            <li><a href="<?php echo site_url('sylabussetup/ctype/' . $id) ?>" title='Course Type'>Course Type</a></li>
            <li><a href="<?php echo site_url('sylabussetup/evaluation/' . $id) ?>" title='Evaluation Type'>Evaluation Type</a></li>
            <li><a href="<?php echo site_url('sylabussetup/course/' . $id) ?>" title='Course'>Course</a></li>
            <li><a href="<?php echo site_url('sylabussetup/examtype/' . $id) ?>" title='Exam Type'>Exam Type</a></li>
        </ul>
    </div>
</div>
<script language='javascript'>
    var stab;
    $(document).ready(function(){
        stab = $("#stab" ).tabs({
            select: function(event, ui) { $("#stab").mask("Loading...");},
            load:   function(event, ui) {  $("#stab").unmask(); },
            cache: false,
            ajaxOptions: {
                cache: false,
                error: function( xhr, status, index, anchor ) {
                    $( anchor.hash ).html("Couldn't load this tab. Please inform system administrator. ");
                }
            }
        }); 
    });

</script>

