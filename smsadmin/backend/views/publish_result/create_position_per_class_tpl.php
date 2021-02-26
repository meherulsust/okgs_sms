<?php $this->tpl->set_js('select-chain');?>
<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 id="add">Create Positions:</h3>
 <form name='frm-book' id='frm-book' method='post' action='<?php echo site_url($active_module)?>/create_positions' >   
     <table cellspacing="0" cellpadding="0" border="0" class="frm-tbl">
        <tr>
            <th class="lbl">
                <label for="test_entry_form_class_id">
                    Class
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <select name="class_id" class="" id="class_id" tabindex="4">
                    <option value="">Select Class</option>
                    <?php 
                    if(!empty($classes)):
                        foreach($classes as $class):
                    ?>
                        <option value="<?php echo $class['id']; ?>">
                    
                            <?php echo $class['title'];  ?> </option>

                    <?php 
                      endforeach;
                      endif;
                    ?> 
                </select>
            </td>            
        </tr>
        <tr>
            <th class="lbl">
                <label for="create_position_form_section_id">
                    Form
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <select name="section_id" class="" id="section_id" tabindex="">
                    <option value="">Select Section</option>                
                </select>
            </td>
        </tr>
        <tr>
            <th class="lbl">
                <label for="test_entry_form_class_id">
                    Examination
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <select name="exam_id" class="" id="exam_id" tabindex="">
                    <option value="">Select Exam</option>
                    <?php 
                    if(!empty($exams)):
                        foreach($exams as $exam):
                    ?>
                        <option value="<?php echo $exam['id']; ?>">
                    
                            <?php echo $exam['title'];  ?> </option>

                    <?php 
                      endforeach;
                      endif;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2" class="btn-container">
                <input type="submit" name="Generate" id="generate" value="Generate" class="btn" />
            </td>
        </tr>
    </table>
</form>  
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#class_id').selectChain({            
	    target: $('#section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'class_id'}
	});
    });
</script>