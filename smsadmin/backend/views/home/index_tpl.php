<div id="rightnow"> 
<?php

if($this->session->userdata('user_group_id')==1)
{
?>
	<div id="dashboard">		
		<a href="<?php echo site_url('menu') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/menu-icon.png" width="64" height="64" alt="edit"/>
			<span>Menu Management</span>
		</a>
		
		<a href="<?php echo site_url('user') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/user-icon.png" width="64" height="64" alt="edit"/>
			<span>User Management</span>
		</a>
		
		<a href="<?php echo site_url('exam') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/exam-icon.png" width="64" height="64" alt="edit"/>
			<span>Examination</span>
		</a>
		
		<a href="<?php echo site_url('student') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/students-icon.png" width="64" height="64" alt="edit" />
			<span>Student Details</span>
		</a>
		
		<a href="<?php echo site_url('school') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/school-icon.png" width="64" height="64" alt="edit" />
			<span>School Details</span>
		</a>
		
		<a href="<?php echo site_url('book') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/book-icon.png" width="64" height="64" alt="edit" />
			<span>Book List</span>
		</a>
		
		<a href="<?php echo site_url('sylabus') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/syllabus-icon.png" width="64" height="64" alt="edit" />
			<span>Syllabus</span>
		</a>
		<a href="<?php echo site_url('teacher') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/teacher-icon.png" width="64" height="64" alt="edit" />
			<span>Teacher Details</span>
		</a>
		<a href="<?php echo site_url('attendance') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/attendance-icon.png" width="64" height="64" alt="edit" />
			<span>Attendance</span>
		</a>
		<a href="<?php echo site_url('exam') ?>" class="dashboard-module">
			<img src="<?php echo $image_url ?>/result-icon.png" width="64" height="64" alt="edit" />
			<span>Result</span>
		</a>
		<div style="clear: both"></div>            
	</div> 
	<?php
	}
	?>
	<div id="page" class="class_content">
		<table align="center" class="dataforgraph">
		<?php foreach($student_list as $val){ ?>	
			<tr>
				<td>
				<?php 
					if($val->class_name!='')
					{
						echo $val->class_name; 
					}else{
						echo 'None';
					}
				?>
				</td>
				<td><?php echo $val->total_student; ?></td>
			</tr>
		<?php } ?>
		</table>
	</div>
	
	<script type="text/javascript">		
		$(document).ready(function() {				
			$('#page').liveGraph({
				height : 350,
				barWidth : 55,
				barGapSize : 2,
				data : 'table.dataforgraph',
				hideData : true
			});
			$('#page').data('liveGraph').settings.hideData = false;
			$('.animation').change(function(){
				if ($(this).val() == "true") {
					$('#page').data('liveGraph').settings.animate = true;
				} else {
					$('#page').data('liveGraph').settings.animate = false;
				}
			});
			$('.animTime').change(function() {
				$('#page').data('liveGraph').settings.animTime = parseInt($(this).val());
			});		
		});			
	</script> 
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php 
	if(!empty($attendance_list))
	{		
	foreach($attendance_list as $val)
	{ 
		/* $section_id = 0;
		$class = 0;
		$section = 0;
		$present = 0;
		$absent = 0; */
		
		/* $section_id = $val['section_id'];
		$class = $val['class_name'];
		$section = $val['section'];
		$present = $val['present'];
		$absent = $val['absent']; */
		
		if($val['present']!=0 AND $val['absent']!=0)
		{
		
	?>	
		<script type="text/javascript">
			google.load('visualization', '1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart<?=$val['section_id'];?>);

			function drawChart<?=$val['section_id'];?>() 
			{
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Pizza');
				data.addColumn('number', 'Populartiy');
				data.addRows([
					['Present', <?=$val['present'];?>],
					['Absent', <?=$val['absent'];?>]
				]);

				var options = {
					title: '<?=$val["section"];?> (<?=$val["class_name"];?>)',
					legend: 'none'      
				}
				var chart = new google.visualization.PieChart(document.getElementById('chart_div<?=$val["section_id"];?>'));
				chart.draw(data, options);
			}
		</script>
		<div id="chart_div<?=$val['section_id'];?>" style="width: 200px; height: 200px;float:left;"></div>
	<?php 
		}		
	}
	}else{
		echo '<h3>No Attendance Report For Today</h3>';
	}
	?>
	
</div>