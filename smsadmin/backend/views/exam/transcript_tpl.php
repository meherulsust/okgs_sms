<html>
    <head>
        <title>Progress Report of <?php echo $regi_info['first_name'].' '.$regi_info['last_name'].' Roll_'.$regi_info['class_roll'];?></title>
        <style type="text/css">
			/* @font-face {
				font-family: myFirstFont;
				src: url(../../../css/font/certificatescript.ttf);
			} */
            table{ border-collapse: collapse; width: 100%;}
            #container{width:100%; min-height:600px;text-align: middle;}
            #content{
				width:900px; 
				height:auto;
				border: 30px solid transparent;
				border-image: url(../../../img/border.png) 50 round;
				margin:25px auto; 
				text-align: center; 
				padding:0 20px 20px 20px;
				
				}
            h2{text-align: center; margin: auto auto;}
            #tbl-std{ width:100%; text-align:}
            #tbl-std td{
				font-family: myFirstFont;
				font-size:20px;
				}
            #tbl-std th{width:220px; text-align:left;}
            #tbl-scale  th ,  #tbl-scale td {  border: 1px solid #D9E6F0;}
            #result-details-tbl th {  border: 1px solid #D9E6F0;}
            #result-details-tbl td.tbl-cont{
                padding: 0 !important;
            }
            #result-details-tbl table{
                margin:0 !important;
            }
            #result-details-tbl td{
                text-align: center;
                vertical-align: middle;
                border: 1px solid #D9E6F0;
            }
            #result-details-tbl table td{
                border:none;
                padding: 3px !important;
                 border: 1px solid #D9E6F0;
            }
            #result-details-tbl table td.lbl{
                border-right: 1px solid #D9E6F0;
                text-align:left !important;
                width: 70%;
            }
            #result-details-tbl table tr{
                border-bottom: 1px solid #D9E6F0;
            }
            #result-details-tbl table tr.lrow{
                border-bottom:none;
            }
			.final_result
			{
				text-align: center;
                vertical-align: middle;
                border: 1px solid #D9E6F0;	
				
			}
			.final_result td
			{
                border: 1px solid #D9E6F0;	
			}
			.result_footer 
			{
                margin-top:30px;
				width:35%;	
			}
			.result_footer td
			{
                border: 1px solid #D9E6F0;
				width:40%;
				
			}
			#content .signiture{
				float:right;
				margin-top:-15px;
				width:50%;
			}
			#content .result_detail td{
				width:33.33%;
			}
			@page 
				{
					size: auto;   auto is the initial value
					margin: 0mm;  this affects the margin in the printer settings
				
				}
			.bg{
				position: absolute;
				left: 0;
				top: 450;
				width: 100%;
				height: auto;
				opacity: 0.1;
			}
			.printbutton{
				margin-left:650px;
				margin-top:-50px;
			}	
        </style>
		<style type="text/css" media="print">
		@page {
			size: auto;   /*auto is the initial value*/
			margin: 0mm;  /*this affects the margin in the printer settings*/
		}
		.printbutton {
			visibility: hidden;
			display: none;
		}
		</style>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <h2><?php echo $school_info['name']; ?></h2>
                <h3><?php echo $regi_info['exam_title']; ?></h3>
				<h2><img width="120" height="120" src="<?php echo base_url() . 'uploads/logo/'.$school_info['logo_file'] ?>" /><h2>
				<h2 class="bg";><img  width="500" height="500" src="<?php echo base_url() . 'uploads/logo/'.$school_info['logo_file'] ?>" /><h2>
                <h2>PROGRESS REPORT</h2>
				<table width="100%" >
                    <tr>
                        <td><strong>Serial No : </strong>IMSN<?php echo $regi_info['class_roll']; ?></td>
                        <td align="right" width="150">
                            <table  cellpadding="1" cellspacing="0" id="tbl-scale">
                                <tr><th>Letter<br>Grade</th><th>Class<br>Interval</th><th>Grade<br>Point</th></tr>
                               <?php foreach($result_matrix as $row): ?>
                               <tr><td><?php echo $row['title']?></td><td><?php echo sprintf('%d',$row['min_range']).'-'.sprintf('%d',$row['max_range']) ?></td>
                                   <td><?php echo $row['weight'] ?></td></tr>
                               <?php endforeach?>
                                
                            </table>
                        </td>
                    </tr>
                </table>
                <table id="tbl-std">
                    <tr><th>Student Name</th><td>:</td><td colspan="4"><?php echo $regi_info['first_name'].' '.$regi_info['last_name']?></td></tr>
                    <tr><th>Father's Name</th><td>:</td><td colspan="4"><?php echo $regi_info['f_first_name'].' '.$regi_info['f_last_name'] ?></td></tr>
                    <tr><th>Mother's Name</th><td>:</td><td colspan="4"><?php echo $regi_info['m_first_name'].' '.$regi_info['m_last_name']; ?></td></tr>
                    <tr><th>Roll No.</th><td>:</td><td><?php echo $regi_info['class_roll']; ?></td><th>Class</th><td>:</td><td><?php echo $regi_info['class']; ?></td></tr>
                    <tr><th>Form</th><td>:</td><td><?php echo $regi_info['section']; ?></td><th>Date of Birth</th><td>:</td><td><?php echo mysql_to_date($regi_info['dob']); ?></td></tr>
					<?php if($regi_info['house_name']): ?>
					<tr><th>House</th><td>:</td><td><?php echo $regi_info['house_name']; ?></td></tr>
					<?php endif; ?>
					
                </table>
               
                <table id="result-details-tbl">
                    <tr>
					<th>SL No.</th>
					<th style="min-width:250px;">Name of Subject</th>
					<th>Pass Marks</th>
					<th>Full Marks</th>
					<th style="min-width:200px;">
						<table><tr><th colspan="3">Marks Details</th></tr>
							<tr>
								 <?php $i=1;foreach ($results as $result): ?>
								 <?php foreach ($result['eval_types'] as $k => $eval): ?>
								 <?php if($i==1)
								 echo '<th>'. $eval['title'].'</th>'; ?>
								 <?php endforeach; ?>	 
								 <?php $i++;endforeach; ?>
							</tr>
						</table>
					</th>
					<th>Marks Obtained</th>
					<th>Letter Grade</th>
					<th>Grade Point</th>
					<th>GPA<?php if ($final_result['weight_with_additional']): ?><br><small>(without additional subject.)</small><?php endif ?></th>
                        <?php if ($final_result['weight_with_additional']): ?> <th>GPA</th><?php endif; ?><th>Class Heighest</th>
                    </tr>
                    <?php $num = 1; foreach ($results as $result): ?> 
                     <tr>
						<td><?php echo $num; ?></td>
						<td style="text-align:left;padding-left:10px;"><?php echo $result['course']; ?></td>
						<td><?php echo $result['percent_to_pass'].'%';?></td>
						<td><?php echo $result['full_marks']; ?></td>
                        <td class="tbl-cont">
                            <table class="result_detail">
                                <tr class="lrow"> 
										<?php  foreach(($result['eval_types']) as $eval):?>
										<td><?php echo $eval['obtain_marks']; ?></td>
										<?php endforeach; ?>
								</tr>
                                <!-- <?php foreach ($result['eval_types'] as $k => $eval): ?>
                                <tr <?php if (($k + 1) == count($result['eval_types'])) echo 'class="lrow"' ?> ><td class="lbl"><?php echo $eval['title'] ?> &nbsp;</td><td><?php echo $eval['obtain_marks'] ?></td></tr>
                                <?php endforeach; ?>-->
                            </table>
                        </td>
                         <td><?php echo $result['obtain_marks']; ?></td><td><?php echo $result['title']; ?></td> <td><?php echo $result['weight'] ?></td>
                        <?php if ($num == 1): ?>
                        <td rowspan="<?php echo $final_result['weight_with_additional']? (count($results) -1) :count($results); ?>" id="gpa"><?php echo $final_result['weight'] ?></td>
            
                            <?php if ($final_result['weight_with_additional']): ?>
                                <td rowspan="<?php echo count($results) ?>" id="agpa"><?php echo $final_result['weight_with_additional'] ?></td>
                             <?php endif; ?>
                     
                        <?php endif; ?>
						<td><?php echo $result['height_marks']; ?></td>	
                    </tr>
                    <?php $num++; endforeach; ?>
					<tr>
						<td colspan="3">Total Full Marks</td><td><?php echo $final_result['full_marks'] ; ?></td>
						<td colspan="">Total Marks Obtained</td><td><?php echo $final_result['obtain_marks'] ; ?></td>
						<td colspan="3">Heighest Total Marks</td><td><?php echo $regi_info['htmark'] ; ?></td>
					</tr>
                </table>
				<table class="final_result">
					<tr>
						<th class="lbl">Result:</th><td><?php if($final_result['is_pass']) echo 'Pass'; else echo 'Fail'; ?></td>
						<th class="lbl">Grade:</th>
						<td><?php echo $final_result['title'] ; ?></td>
					</tr>
					<!--<tr>
						<th class="lbl">Result:</th>
						<td><?php if($final_result['is_pass']) echo 'Pass'; else echo 'Fail'; ?></td>
						<th class="lbl">Grade:</th>
						<?php if($final_result['is_pass']>0): ?>
							<td><?php echo $final_result['title'] ; ?></td>   
						<?php else:?>
							<td>F</td>
						<?php endif;?>    
					</tr>-->
				</table>
				
				<table class="result_footer">
					<tr>
						<td><strong>Total Working Days</strong></td><td>100</td>
					</tr>
					<tr>	
						<td><strong>Total Attandance</strong></td><td>80</td>
					</tr>
					<tr>	
						<td><strong>Discipline</strong></td><td>good</td>
					</tr>	
				</table>
				<table class="signiture">
					<tr>
						<td><strong>Form Teacher's Signiture</strong></td><td><strong>Principle's Signiture</strong></td>
					</tr>	
				</table>
			</div>
			<div>
				<button class="printbutton" onclick="myFunction()">Print</button>

			<script>
					function myFunction() {
						window.print();
					}
			</script>

			</div>
            </div>
    </body>
</html>
