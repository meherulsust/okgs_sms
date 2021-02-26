	
<?php
/*
 * Created on Feb 04, 2016
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Attendancemodel extends Frontend_Model
 {
 	function __construct()
 	{
 		parent::__construct(); 		
 	}	 	
	
	/*for attendence */
	
	public function working_days(){
			  $this->db->select('DISTINCT(date)');
			  $this->db->from('student_attendance');
			  $this->db->where('YEAR(date)',date('Y'));
			  $rs=$this->db->get(); 	    
		return $rs->num_rows();		
	}
	public function total_attendance($student_id){
		$query = $this->db->select('DISTINCT(date)')
				->from('student_attendance')
				->where('student_id',$student_id)
				->where('attendance_status','Present')
				->where('YEAR(date)',date('Y'));	
				 $rs=$this->db->get(); 	    
		return $rs->num_rows();
	}	
	
	/*end*/
	}	