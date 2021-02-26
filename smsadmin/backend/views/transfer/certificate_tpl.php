<style type="text/css">
    body {
        height: 842px;
        width: 595px;
        margin-left: auto;
        margin-right: auto;
    }
    .school-name{font-size: 1.5em; height:50px;}
    .address{text-align: center;font-size: .9em; height:30px;}
    #certificate{width:100%; height:auto;}
    .text{text-align: justify;}
    .title{ text-align: center;height:30px;}
     ul{list-style: decimal;}
    #seal {float: left;}
    #sign{float:right;}
    tfoot td{text-align: center; font-size: .9em;}
  
</style>

<table id="certificate">
    <thead><tr><th class="school-name">Kalai M.U Highschool</th></tr></thead>
    <tbody>
        <tr><td class="address">Post - Kalai, Thana - Kalai Dist - Joyourhat,Bangladesh</td></tr>
        <tr><td class="title"> <u><strong>SCHOOL TRANSFER CERTIFICATE</strong> </u></td></tr>
<tr><td class="text">This is to consenting that <?php echo strtoupper($student_name) ?>, Father- <?php echo ucwords(strtolower($father_name)); ?>, Mother- <?php echo ucwords(strtolower($mother_name)); ?> of Post Office- <?php echo $post_office; ?>, P.S-<?php echo $thana ?>, Dist-<?php echo $district ?>, 
        he had been studying in this school up to the dated: <?php echo mysql_to_date($transfer_date) ?> . 
        As per description of admission book his date of birth is: <?php echo mysql_to_date($dob) ?>.
        He used to read in class <?php echo $class ?>. His age was <?php echo age($dob) ?> period of school transfer. 
        All the dues from him was received with understanding up to the dated: <?php echo mysql_to_date($transfer_date) ?>.<br>
        His moral character :   Good <br>
        Student  Number: <?php echo $student_number; ?> <br>
        Cause of leaving school :<br>
        <ul><li><?php echo $reason ?></li></ul>
    </td></tr>
  <tr><td class="down"><div id="seal"> Kalai m.u highschool</div><div id="sign">Abdul Mannan<br>Head Master<br>Sign:_____________<br>Date: <?php echo date('d/m/Y')?></div></td></tr>
</tbody>
<tfoot>
    <tr><td>It is computer generated letter.</td></tr>
</tfoot>
</table>
