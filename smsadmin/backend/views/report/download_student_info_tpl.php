<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$report_file_name);
	header("Pragma: no-cache");
	header("Expires: 0");		
?>
<style type="text/css">
.main_table{
    /*width:100%;*/  
    /*margin-top:15px;*/
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr{
/*    width:100%;      */
}
.main_table tr th{
	padding:2px 4px;
    font-size:12px;
    border:1px solid #000;
    border-collapse: collapse;
}
.main_table tr td{
    font-size:12px;
    padding:2px 4px;
    border:1px solid #000;
    border-collapse: collapse;
}
.head_table{
    width:100%;  
    border-collapse: collapse;
    border: 0px !important;    
} 
#printview {
  overflow-x: auto;
  overflow-y: hidden;
}
/*.main_table thead {
   display:table-header-group;
}
.main_table tbody {
   display:table-row-group;
}
@media print {
.main_table thead {display: table-header-group;}
}*/
</style>
<div id="box">
<h3 id="add">Student Information</h3>
<p><strong>Date: </strong><?=date("D-M-Y")?><br/><br/></p>
    <div id="container">
        <div id="content">
            <div id="printview">
            <table class="main_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FULL NAME</th>
						<th>DATE OF BIRTH</th>
                        <th>FATHER & MOTHER NAME</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
                        <th>ROLL</th>
                        <th>RELIGION</th>
                        <th>ADDRESS</th>
                        <th>MOBILE</th>
                        <th>STUDENT TYPE</th>
                        <th>PICTURE</th>
                        <th>SIGNATURE</th>
                    </tr>
                </thead>
                <?php
                if(!empty($report_list)){
                    $x = 1;
                    foreach ($report_list as $std){
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $std['first_name'].' '.$std['last_name'];  ?></td>
					<td><?php echo $std['dob'];  ?></td>
                    <td><?php echo $std['father_name'].'<br/>'.$std['mother_name'];  ?></td>
                    <td><?php echo $std['class'];  ?></td>
                    <td><?php echo $std['section'];  ?></td>
                    <td><?php echo $std['class_roll'];  ?></td>
                    <td><?php echo $std['religion'];  ?></td>
                    <td><?php 
                    echo $std['address_line'];  
                    if(!empty($std['thana'])){ echo ', '.$std['thana'];}else{ echo '';}
                    if(!empty($std['district'])){ echo ', '.$std['district'];}else{ echo '';}
                    if(!empty($std['post_office'])){ echo ', '.$std['post_office'];}else{ echo '';}
                    ?></td>
                    <td><?php echo $std['mobile'];  ?></td>
                    <td><?php echo $std['student_type'];  ?></td>
                    <td width="100" height="100">
					<img src="<?php echo base_url();?>uploads/std_photo/<?php echo $std['file_name']; ?>" width="100" height="100" alt="" />
					</td>
                    <td></td>
                </tr>
                <?php 
                $x++;
                    }} ?>
            </table>
        </div>
        </div>
    </div>
</div>
