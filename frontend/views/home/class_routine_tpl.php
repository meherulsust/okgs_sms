<style type="text/css" media="print">
    @media print {		  
        body * {			
            visibility: hidden;		  
        }		  
        #section-to-print * {			
            visibility: visible;		  
        }		
    }		
    @page {			
        size: auto;   /*auto is the initial value*/			
        margin: 0mm;  /*this affects the margin in the printer settings*/		
    }		
    .printbutton {			
        visibility: hidden;			
        display: none;		
    }
</style>

<div id="section-to-print">
<h1>Class Routine</h1>
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Class </b></td>
		<td><b><?php echo $class; ?></b></td>			
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Form </b> </td>
		<td><b><?php echo $section;?></b></td>			
	</tr>
</table>		
<div id="routine" style='border:1px solid gray;'>
    <table width="80%" align="center" class="list_table">
            <tr height="55" style='border:1px solid gray;'>
                    <td bgcolor="AEECE7" style='border:1px solid gray;'></td>
                    <?php foreach($time_list as $time){ ?>	
                    <td bgcolor="AEECE7" align="center" style='border:1px solid gray;'><b><?php echo $time['title']; ?></b></td>	
                    <?php }	?>	
            </tr>
            <?php foreach($day_list as $day){ ?>
            <tr height="55" style='border:1px solid gray;'>
                    <td bgcolor="#C7F2EE" align="center" style='border:1px solid gray;'><b><?php echo $day['title']; ?></b></td>
                    <?php 
                    foreach($time_list as $time){
                    ?>
                    <td align="center" style='border:1px solid gray;'>
                    <?php	
                    foreach($routine_list as $routine){ 
                            if($routine['class_day_id']==$day['id'] AND $routine['class_time_id']==$time['id']){
                                    echo $routine['subject'].'<br/>'.$routine['teacher_name'];
                            }
                    }	
                    ?>	
                    </td>				
                    <?php 				

                    }
                    ?>
            </tr>
            <?php } ?>       
    </table>
</div>

<div>	
    <button class="printbutton" onclick="myFunction()">Print</button>
</div>
</div> 

<script>	
    function myFunction() {		window.print();	}
</script>