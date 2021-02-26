
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

<div id="box">
	<h3 id="adduser">Teacher Routine</h3>
	<div id='std-create'>
		<form id="frm-generate Payment" method='POST' enctype="multipart/form-data" action='<?php echo site_url($active_module.'/class_routine'); ?>'>
		<table cellspacing='0' cellpadding='0' border='0' class='frm-tbl'>
			<?php echo $this->teacher_routineform->render(); ?>
		</table>	
		<?php echo $this->teacher_routineform->render_hidden(); ?>
		</form>
	</div>
</div>

<div id="section-to-print" >
	<h2 align="center" style='color:green'>IBRAHIM MEMORIAL SHIKSHA NIKETAN BIRGANJ, DINAJPUR</h2>
	<div id="routine" style='border:1px solid gray;'>	
	<table width="80%" align="center" class="list_table" >	
		<?php foreach($day_list as $day){ ?>
		<tr height="55" style='border:1px solid gray;'>
			<td bgcolor="#C7F2EE" align="center" width='15%'style="border:1px solid gray"><b><?php echo $day['title']; ?></b></td>
			<td align="center">
			<?php	
			foreach($routine_list as $routine){ 
				if($routine['class_day_id']==$day['id']){
						echo'<td style="border:1px solid gray" align="center">';
							echo '<strong>'.$routine['time'].'</strong>'.'<br/>'.$routine['subject'].'<br/>'.'<strong>'.$routine['class'].'</strong>'.'<br>'.$routine['section'].'<br/>';
						echo'</td>';
				}
				
			}	
			?>	
			</td>				
			<?php 				
			
			}
			?>
		</tr>     
	</table>
	</div>
    <br />
    <?php if(!empty($extra_classes)){ ?>
        <h2 align="center" style='color:green'>Extra Classes</h2>
	<div id="routine" style='border:1px solid gray;'>	
	<table width="80%" align="center" class="list_table" >	
		<?php foreach($day_list as $day){ ?>
            <tr height="55" style='border:1px solid gray;'>
                <td bgcolor="#C7F2EE" align="center" width='15%'style="border:1px solid gray"><b><?php echo $day['title']; ?></b></td>
                <td align="center">
                <?php	
                foreach($extra_classes as $routine){ 
                    if($routine['class_day_id']==$day['id']){
                        echo'<td style="border:1px solid gray" align="center">';
                                echo '<strong>'.$routine['time'].'</strong>'.'<br/>'.$routine['subject'].'<br/>'.'<strong>'.$routine['class'].'</strong>'.'<br>'.$routine['section'].'<br/>'. date('d-m-Y', strtotime($routine['class_date']));
                        echo'</td>';
                    }
                }	
                ?>	
                </td>				
                <?php 				

                }
                ?>
            </tr>     
	</table>
	</div>
        
    <?php } ?>
    <div>
        <button class="printbutton" onclick="myFunction()">Print</button>
    </div>
</div> 

<script>
	function myFunction() {
		window.print();
	}
</script>					