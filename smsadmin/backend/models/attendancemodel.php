<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 06, 2012
 * Model class for exam.
 */
class Attendancemodel extends BACKEND_Model
 {
 	public function __construct()
 	{
 	   	parent::__construct();
 	}
	
	public function get_table_name()
	{
		return 'student_attendance';
	}
    
	public function get_columns() {
        return array('id', 'student_id', 'date' ,'attendance_status', 'updated_at', 'updated_by', 'created_at', 'created_by');
    }
	
	public function grid_query(){
        $this->info_query();      
	}
	
	public function get_info($id)
	{
		$sql = $this->info_query();
		$sql->where('att.id',$id);	  
		$query  = $sql->get();
		return $query->row_array();		  
	}
  
		
	public function info_query(){
		$query = $this->db->select('att.id,att.attendance_status,att.date,att.created_at,att.updated_at,st.student_number,st.mobile,st.full_name,class,section,class_roll')
				->from('student_attendance att')		
				->join('student_v st','st.id=att.student_id','left')
				->order_by('att.date','desc');             
		return $query;
	}
	
		   
	public function attendance_count(){
		$query = $this->db->select('att.id')
				->from('student_attendance att')		
				->join('student_v st','st.id=att.student_id','left');
		return $query->count_all_results();
	}
	
	public function save_attendance($data)
	{		
		$this->insert_batch($data);		
	}
  
	function get_student_list($class_id,$section_id)
	{
		$this->db->select('sms_student.id student_id,sms_student.student_number,CONCAT(sms_personal_details.first_name," ",sms_personal_details.last_name) as student_name,sms_admission.class_roll',False);
		$this->db->from('sms_student');
		$this->db->join('sms_admission','sms_admission.id=sms_student.admission_id','left');
		$this->db->join('sms_personal_details','sms_personal_details.id=sms_student.personal_details_id','left');
		$this->db->join('sms_class','sms_class.id=sms_admission.class_id','left');
		$this->db->where('sms_student.status_id',1);
		$this->db->where('sms_admission.class_id',$class_id);
		$this->db->where('sms_admission.section_id',$section_id);
		$this->db->order_by('sms_admission.class_roll','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
  
	public function delete($id)
	{
		$this->load->model('examsylabusmodel','esm');
		$this->esm->delete_where(array('exam_id'=>$id));
		parent::delete($id);
	}
	
	
	public function get_attendance()
	{
		$this->db->select('s.id section_id,s.title section,c.id class_id,c.title class_name');		
 	 	$this->db->from('section s');
		$this->db->join('class c','c.id=s.class_id','left');
		$this->db->where('s.status','ACTIVE');
		$this->db->where('c.status','ACTIVE');
		$this->db->order_by('c.serial','asc');
		$rs=$this->db->get(); 
		$aa = array();
		foreach($rs->result() as $row)
		{
			$data['section_id'] = $row->section_id;
			$data['class_name'] = $row->class_name;
			$data['section'] = $row->section;
			$data['date'] = date('Y-m-d');
			$data['present'] = $this->get_present($row->section_id);
			$data['absent'] = $this->get_absent($row->section_id);
			$aa[] = $data;
		}
		return $aa; 
	}
	
	
	public function get_present($section_id)
	{
		$query = $this->db->select('att.id')
				->from('student_attendance att')		
				->join('student_v st','st.id=att.student_id','left')
				->where('att.attendance_status','Present')
				->where('att.date',date('Y-m-d'))
				->where('st.section_id',$section_id);
		return $query->count_all_results();
	
	}
	
	public function get_absent($section_id)
	{
		$query = $this->db->select('att.id')
				->from('student_attendance att')		
				->join('student_v st','st.id=att.student_id','left')
				->where('att.attendance_status','Absent')
				->where('att.date',date('Y-m-d'))
				->where('st.section_id',$section_id);
		return $query->count_all_results();
	
	}
	
	public function abcent_info($data)
	{
		$this->db->insert('message_sent_list',$data);
		return $this->db->insert_id();
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
    function check_attendance($student_id, $class_id, $section_id, $attendance_date) {
        $this->db->select('satt.id');
        $this->db->from('student_attendance satt');
        $this->db->join('admission ad', 'ad.student_id = satt.student_id', 'left');
        $this->db->where('satt.student_id', $student_id);
        $this->db->where('satt.date', $attendance_date);
        $this->db->where('ad.class_id', $class_id);
        $this->db->where('ad.section_id', $section_id);
        $rs = $this->db->get();
        return $rs->num_rows();
    }
    public function range_present($student_id, $date_from = '', $date_to = ''){
        $this->db->select('DISTINCT(date)');
        $this->db->from('student_attendance');
        $this->db->where('student_id',$student_id);
        $this->db->where('attendance_status','Present');
        if($date_from != ''){
        $this->db->where('date >=', $date_from);	
        }
        if($date_to != ''){
        $this->db->where('date <=', $date_to);
        }
        if($date_from == '' && $date_to == ''){
        $this->db->where('YEAR(date)',date('Y'));    
        }
        $rs=$this->db->get(); 
        return $rs->num_rows();
    }    
    public function get_student_ids($class_id, $section_id, $name = '', $number = '') {
        $this->db->select('st.id, v.class, v.full_name, v.student_number, v.section, v.class_roll');
        $this->db->from('student st');
        $this->db->join('admission ad', 'ad.student_id = st.id', 'left');
        $this->db->join('student_v v', 'v.student_number = st.student_number', 'left');
        if($class_id != ''){
        $this->db->where('ad.class_id', $class_id);
        }
        if(isset($section_id) && $section_id > 0){
            $this->db->where('ad.section_id', $section_id);
        }
        if($name != ''){
            $this->db->like('v.full_name', $name);
        }
        if($number != ''){
            $this->db->where('v.student_number', $number);
        }
        $this->db->where('st.status_id', '1');
        $this->db->order_by('v.class_roll');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function total_working_days($date_from, $date_to){
        $this->db->select('DISTINCT(date)');
        $this->db->from('student_attendance');
        if($date_from != ''){
            $this->db->where('date >=', $date_from);
        }
        if($date_to != ''){
            $this->db->where('date <=', $date_to);
        }
        if($date_from == '' && $date_to == ''){
            $this->db->where('YEAR(date)',date('Y'));
        }
        $rs=$this->db->get();
        return $rs->num_rows();		
    }
 } 
?>