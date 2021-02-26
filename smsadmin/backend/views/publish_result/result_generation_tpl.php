<div id="box">
    <h3 id="add">Result Generation:</h3>
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
                <label for="test_entry_form_class_id">
                    Examination
                </label>
            </th>
            <td class="cln">:</td>
            <td>
                <select name="exam_id" class="" id="exam_id" tabindex="">
                    <option value="">Select Class</option>
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
    </table>
    <!--Displaying Half Yearly Examination Transcript-->
    <?php
        $exam_id = $this->input->get('exam_id');
        $class_id = $this->input->get('class_id');
        if($exam_id == '2' && $class_id <= 5):
    ?>
    <table id="result-details-tbl">
        <tr>
            <td colspan="6">CT Marks</td>
            <td rowspan="2">Term Total <br />(100)</td>
            <td rowspan="2">Grand Total (GT)<br />(20%+80%)</td>
            <td rowspan="2">Grade Point <br /> (GP)</td>
            <td rowspan="2">Later Grade <br />(LG)</td>
            <td rowspan="2">Class Heighest <br /> (CH)</td>
            <td rowspan="2">Total <br /> Mks</td>
            <td rowspan="2">Result Status</td>
            <td rowspan="2">Posn</td>
        </tr>
        <tr>
            <td>Sub</td>
            <td>Mks</td>
            <td>Pass</td>
            <td>CT1</td>
            <td>CT2</td>
            <td>CT-Avg</td>
        </tr>
        <?php if(!empty($results)):  
                foreach ($results as $result):                        
        ?>
        <tr>
            <td><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td>100</td>
            <td>50%</td>
            <td><?php if(!empty($result['ct1'])): ?><?php echo $result['ct1']; else: echo ''; ?><?php endif; ?></td>
            <td><?php if(!empty($result['ct2'])): ?><?php echo $result['ct2']; else: echo ''; ?><?php endif; ?></td> 
            <td><?php if(!empty($result['ct1']) && !empty($result['ct2'])): echo $ct_avg = ceil($result['ct1']+$result['ct2'])/2; endif;?></td>
            <td><?php echo $term_total = $result['creative']+$result['mcq']+$result['practical'] ?></td>
            <td><?php echo $result['half_yearly_grand_total'];  ?></td>
            <td><?php echo $result['half_yearly_gp'];  ?></td>
            <td><?php echo $result['half_yearly_lg'];  ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php   
            endforeach;
        endif;
        ?>
    </table>
    <?php endif;  ?>
    
    <!--Displaying Yearly Examination(I-V) Transcript-->
    <?php
        $exam_id = $this->input->get('exam_id');
        $class_id = $this->input->get('class_id');
        if($exam_id == '3' && $class_id <= 5):
    ?>
    <table id="result-details-tbl">
        <tr>
            <td colspan="6">CT Marks</td>
            <td rowspan="2">Term Total</td>
            <td rowspan="2">Grand Total (GT)<br />(20%+80%)</td>
            <td rowspan="2">Grade Point <br /> (GP)</td>
            <td rowspan="2">Later Grade <br />(LG)</td>
            <td rowspan="2">Class Highest <br /> (CH)</td>
            <td colspan="6">Final Result</td>            
            <td rowspan="2">Total <br /> Mks</td>
            <td rowspan="2">Result Status</td>
            <td rowspan="2">Posn</td>
        </tr>
        <tr>
            <td>Sub</td>
            <td>Mks</td>
            <td>Pass</td>
            <td>CT3</td>
            <td>CT4</td>
            <td>CT-Avg</td>
        
            <td>HY <br />Mks</td>
            <td>Yearly <br />Mks</td>
            <td>(HY+Y)<br />Avg</td>
            <td>GP</td>
            <td>LG</td>
            <td>CH<br />Avg</td>
        </tr>
        <?php // print_r($results);
        if(!empty($results)):  
                foreach ($results as $result):
            if(!empty($result['creative'])){ 
//                echo $term_total = $result['creative']+$result['mcq']+$result['practical'];
                
            }            
        ?>
        <tr>
            <td><?php if(!empty($result['subject_name'])): echo $result['subject_name']; else: echo '';  endif; ?></td>
            <td>100</td>
            <td>50%</td>
            <td><?php if(!empty($result['ct3'])): ?><?php echo $result['ct3']; else: echo ''; ?><?php endif; ?></td>
            <td><?php if(!empty($result['ct4'])): ?><?php echo $result['ct4']; else: echo ''; ?><?php endif; ?></td> 
            <td><?php if(!empty($result['ct3']) && !empty($result['ct4'])): echo $ct_avg = ceil($result['ct3']+$result['ct4'])/2; endif;?></td>
            <td><?php if(!empty($result['term_total'])){echo $result['term_total'];}else{} ?></td>
            <td><?php echo $result['yearly_grand_total'];  ?></td>
            <td><?php echo $result['yearly_gp'];  ?></td>
            <td><?php echo $result['yearly_lg'];  ?></td>
            <td></td>
            <td><?php if(!empty($result['half'])){echo $result['half'];}else{} ?></td>
            <td><?php if(!empty($result['yearly_grand_total'])){echo $result['yearly_grand_total'];}else{} ?></td>
            <td><?php if(!empty($result['half'])&& !empty($result['yearly_grand_total'])){ echo $yearly_avg = ($result['half']+$result['yearly_grand_total'])/2;} ?></td>
            <td><?php echo $result['final_gp'];  ?></td>
            <td><?php echo $result['final_lg'];  ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php   
            endforeach;
        endif;
        ?>
    </table>
    <?php endif;  ?>
    
    <!--Displaying Half Yearly Examination(VI-VII) Transcript-->
    <table id="result-details-tbl">
        <tr>
            <td colspan="6">CT Marks</td>
            <td colspan="4">Term Total (100)</td>
            <td rowspan="2">Grand Total (GT)<br />(20%+80%)</td>
            <td rowspan="2">Grade Point <br /> (GP)</td>
            <td rowspan="2">Later Grade <br />(LG)</td>
            <td rowspan="2">Class Highest <br /> (CH)</td>
            <td rowspan="2">Total <br /> Mks</td>
            <td rowspan="2">Result Status</td>
        </tr>
        <tr>
            <td>Sub</td>
            <td>Mks</td>
            <td>Pass</td>
            <td>CT1</td>
            <td>CT2</td>
            <td>CT-Avg</td>
            
            <td>Creative</td>
            <td>MCQ</td>
            <td>Practical</td>
            <td>Total <br />(C+M+P)</td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $('#exam_id').change(function(){
        var class_id = $('#class_id').val();
        var exam_id = $('#exam_id').val();
        window.location.replace('<?php echo base_url(); ?>index.php/publish_result/result_generation?class_id='+class_id+'&exam_id='+exam_id);
    });

</script>    
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
       var class_id = getUrlParameter('class_id');
       var exam_id = getUrlParameter('exam_id');
       $('#class_id').val(class_id);
       $('#exam_id').val(exam_id);
   });
</script>