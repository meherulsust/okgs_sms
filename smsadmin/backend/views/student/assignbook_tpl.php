<?php $this->tpl->set_js('admission_course'); ?>
<div id='box' class='admission-course'>
<?php $this->tpl->load_element('flash_message'); ?>
<form name='frm_assign_course' id='assign_course' method='post' action='<?php echo site_url('student/savecourse'); ?> ' >
<?php foreach($course_types as $type_id=>$title): ?>
<?php 
	$checked_all='';
	$ac_row = array();
	if(isset($assigned_courses[$type_id]))
	{		 
	 	$ac_row = array_assoc_by_key($assigned_courses[$type_id],'course_id');
		if(count($assigned_courses[$type_id]) == count($courses[$type_id]))
		$checked_all = 'checked="checked"'; 
		
	}   		 	
?> 
<h3><input type='checkbox' title='Select All' class='sel-all' value='<?php echo $type_id ?>' <?php echo $checked_all; ?> name='check_all' /> <?php echo $title ?>
</h3>
<ul class='tablelike'>
<?php foreach($courses[$type_id] as $i=>$row): ?>
	
	  <?php 
	         $checked = '';
	  		 if(isset($ac_row[$row['id']]))
	  		 $checked = 'checked = "checked"';	 
	  ?>
	  
	 <li><input type='checkbox' class="ctype_<?php echo $type_id ?>" name='adcrs[<?php echo $type_id ?>][<?php echo $i ?>][course_id]' value = "<?php echo $row['id']?>"  <?php echo $checked ?>/>
	 <?php echo $row['title']; ?> <input type='hidden' name='adcrs[<?php echo $type_id ?>][<?php echo $i ?>][id]' value="<?php echo $checked ? $ac_row[$row['id']]['id']:'' ?>"></li>
<?php endforeach ?>
</ul>

<?php endforeach ?>
<input type='hidden'  name='admission_id' value="<?php echo $admission_id ?>" />
<div class='btn-container'>
<input class="btn" type="submit" value="Submit" name="submit">
<button id="cancel-btn" class="btn" type="button">Cancel</button>
</div>
<div class='clr'></div>
</form>
</div>
<div id='alert-message'><div>You did not select any course. Please select course for this admission. </div></div>