<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
 class Studenthousemodel extends BACKEND_Model
 {
	public function __construct()
	{
		parent::__construct();
	}
  
    public function get_columns()
	{
   	  return array('id','house_id','student_id','create_date','update_date');
	}
  
	public function get_table_name()
	{
		return 'student_house';
	}

   
    public function grid_query() {
        $query = $this->db->select('sh.id,st.student_number,sh.create_date,sh.update_date,CONCAT(pd.first_name," ",pd.last_name) as student_name,cl.title as class_name,sec.title section_name,house.title house_name,ad.class_roll',False)
				->from('student_house sh')		
				->join('student st','st.id=sh.student_id','left')	
				->join('admission ad','ad.id=st.admission_id','left')
				->join('personal_details pd','pd.id=st.personal_details_id','left')
				->join('class cl','cl.id=ad.class_id','left')
				->join('section sec','sec.id=ad.section_id','left')
				->join('house','house.id=sh.house_id','left');
    }
   
	
	public function student_list(){
		$query = $this->db->select('sh.id,st.student_number,sh.create_date,sh.update_date,st.full_name,class,section,class_roll,house.title house_name')
				->from('student_house sh')		
				->join('student_v st','st.id=sh.student_id','left')	
				->join('house','house.id=sh.house_id','left');             
		return $query;
	}
   
	public function student_count(){
		$query = $this->db->select('sh.id')
				->from('student_house sh')		
				->join('student_v st','st.id=sh.student_id','left')	
				->join('house','house.id=sh.house_id','left');
       return $query->count_all_results();
	}
	
	
	function get_student_list($house_id='',$class_id,$section_id)
	{
		$this->db->select('sms_student.id student_id,sms_student.student_number,CONCAT(sms_personal_details.first_name," ",sms_personal_details.last_name) as student_name,sms_admission.class_roll',False);
		$this->db->from('sms_student');
		$this->db->join('sms_admission','sms_admission.id=sms_student.admission_id','left');
		$this->db->join('sms_personal_details','sms_personal_details.id=sms_student.personal_details_id','left');
		$this->db->join('sms_class','sms_class.id=sms_admission.class_id','left');
		if($house_id!=''){
		$this->db->join('sms_student_house','sms_student_house.student_id=sms_student.id','left');
		$this->db->where('sms_student_house.house_id',$house_id);
		}
		$this->db->where('sms_student.status_id',1);
		$this->db->where('sms_admission.class_id',$class_id);
		$this->db->where('sms_admission.section_id',$section_id);
		$this->db->order_by('sms_admission.class_roll','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}	
	
	
	function add_student($data)
	{
		$this->db->insert('student_house',$data);
		return $this->db->insert_id();
	}
        
    public function count_student($student_id){
		$query = $this->db->select('sh.id')
				->from('student_house')		
				->where('student_id',$student_id);
       return $query->count_all_results();
	}   
     
	function update_student_house($student_id,$data)
	{
		$this->db->update('student_house',$data,array('student_id'=>$student_id));
	}	
	
 }

?>