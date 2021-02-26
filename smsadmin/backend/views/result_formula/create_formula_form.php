<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>    
</ul>
<span style="color: #FF0000;" id="errmsg"></span>
<?php 
    $edit_id = $this->uri->segment(3); 
    $onvalid = $this->uri->segment(2); 
    if(!empty($edit_id) || $onvalid == 'update'):
?>
<form name='frm-config-exam-classes' id='frm-config-exam-classes' method='post' action='<?php echo site_url($active_module.'/update')?>' >
<?php else:  ?>
<form name='frm-config-exam-classes' id='frm-config-exam-classes' method='post' action='<?php echo site_url($active_module.'/save')?>' >
<?php endif;  ?>
<fieldset id="config_exam_classes"><legend>Create Formula</legend>        
              
        <div class="clear"></div>
        <div class="class_test_checkbox">
        <?php  $x = 1;
            if(!empty($tests)):
                foreach($tests as $test):
        ?>
            <button class="exam_type_name" name="<?php echo $test['field_name']; ?>" id="<?php echo $test['field_name']; ?>" value="<?php echo $test['field_name']; ?>"><?php echo $test['title']; ?></button>
        <br>
        <?php if($x%2 == 0): ?>
        </div>
        <div class="class_test_checkbox">
        <?php endif;  ?>
        <?php   $x++;
                endforeach;  
            endif;
        ?>
        </div>
        
        <div class="operators">
            <label>Select Operators</label>
            <br /><br />
            <div class="operator_segment">
                <button class="operator_name" name="plus" id="plus" value="+">+</button> 
                <button class="operator_name" name="minus" id="minus" value="-">-</button>
                <button class="operator_name" name="multiply" id="multiply" value="*">*</button>
                <button class="operator_name" name="division" id="division" value="/">/</button>
                <button class="operator_name" name="modulus" id="modulus" value="%">%</button>
                <button class="operator_name" name="equals" id="equals" value="=">=</button>
                <button class="operator_name" name="braces_left" id="braces_left" value="(">(</button>
                <button class="operator_name" name="braces_right" id="braces_right" value=")">)</button>
                <button class="operator_name" name="square_braces_left" id="square_braces_left" value="[">[</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="]">]</button>
            </div>
            <div class="operator_segment">                
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="0">0</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="1">1</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="2">2</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="3">3</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="4">4</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="5">5</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="6">6</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="7">7</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="8">8</button>
                <button class="operator_name" name="square_braces_right" id="square_braces_right" value="9">9</button>
            </div>
        </div>
        <div class="form_input_fields">
            <table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
                <?php echo $this->create_formula_form->render();  ?>
                <tr>
                    <th class="lbl"></th><td class="cln"></td>
                    <td>
                        <div class="formula_section">
                            <!--<input type="hidden" name="hidden_formula" id="hidden_formula" value="" />-->
                            
                            <input type="submit" class="btn" value="Submit" name="submit" id="submit_formula">
                            <input type="button" class="btn" value="Reset Formula" name="form_reset" id="form_reset">
                            <button class="btn" id="btn-cancel" type="button">Cancel</button>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
    <?php echo $this->create_formula_form->render_hidden();  ?>
</form>
<script type="text/javascript">
$(document).ready(function(){
    $(" .exam_type_name ").click(function(e){
        e.preventDefault();
        $('#create_formula_formula').val($('#create_formula_formula').val() + $(this).text());
        $('#create_formula_hidden_formula').val($('#create_formula_hidden_formula').val() + $(this).val());

    });
    
    $('.operator_name').click(function(e){
        e.preventDefault();
        $('#create_formula_formula').val($('#create_formula_formula').val() + $(this).val());
        $('#create_formula_hidden_formula').val($('#create_formula_hidden_formula').val() + $(this).val());
    });
    $('#form_reset').click(function(){
        $('#create_formula_formula').val('');
        $('#create_formula_hidden_formula').val('');
//        $('#create_formula_class_id').prop('selectedIndex',0);
//        $('#create_formula_subject_id').prop('selectedIndex',0);
    });
});
</script>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo base_url(); ?>index.php/result_formula";
       }); 
    });
</script>
<script>
  
<?php
    $uri_class = $this->input->get('class');
    if(!empty($uri_class)):
        echo $uri_class;
?> 
<script>   
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    
  $(window).load(function(){
            var class_id = getUrlParameter('class');
            var subject_id = getUrlParameter('subject');
            $('#create_formula_class_id').val(class_id);
            $('#create_formula_subject_id').val(subject_id);
   });      
</script>   
<?php 
endif;
?>
