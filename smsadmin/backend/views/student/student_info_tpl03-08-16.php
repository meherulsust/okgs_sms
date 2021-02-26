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
<div id="box"><h3 id="add">Information Sheet</h3>
    <div id="container">
        <div id="content">
            <div id="printview">
            <table class="main_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FULL NAME</th>
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
                if(!empty($std_info)){
                    $x = 1;
                    foreach ($std_info as $std){
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $std['first_name'].' '.$std['last_name'];  ?></td>
                    <td><?php echo $std['father_name'].'<br />'.$std['mother_name'];  ?></td>
                    <td><?php echo $std['class'];  ?></td>
                    <td><?php echo $std['section'];  ?></td>
                    <td><?php echo $std['class_roll'];  ?></td>
                    <td><?php echo $std['religion'];  ?></td>
                    <td><?php echo $std['address_line'];  ?></td>
                    <td><?php echo $std['mobile'];  ?></td>
                    <td><?php echo $std['student_type'];  ?></td>
                    <td><img src="<?php echo base_url();?>uploads/std_photo/<?php echo $std['file_name']; ?>" width="100" height="100" alt="" /> </td>
                    <td></td>
                </tr>
                <?php 
                $x++;
                    }} ?>
            </table>
            <table>
                <tr>
                    <td align="center">
                        <button onclick="printthis()"  style="float: right; margin: 0 10px 0;">Print Record</button>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </div>
</div>
<script>
    function print_view(url) {
        startload();
        window.open(url, '_blank');
        if (window.focus) {newwindow.focus()}
        removeload()
        return false;	
    }
    function printthis() {
        var printContents = document.getElementById('printview').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }    
</script>