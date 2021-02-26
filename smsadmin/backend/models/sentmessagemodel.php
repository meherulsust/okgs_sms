<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
 class Sentmessagemodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
  
    public function get_columns()
	{
   	  return array('id','student_id','message','status','created_at');
	}
  
   public function get_table_name()
   {
   	 return 'message_sent_list';
   }

   
    public function grid_query() {
        $query = $this->db->select('sm.id,sm.status,sm.student_id,sm.created_at,mn.title message,CONCAT(pd.first_name," ",pd.last_name) as student_name,pd.mobile,cl.title as class_name,sec.title section_name,ad.class_roll,house.title house_name',False)
				->from('message_sent_list sm')			
				->join('message_notification mn','mn.id=sm.message_id','left')
				->join('student st','st.id=sm.student_id','left')
				->join('admission ad','ad.id=st.admission_id','left')
				->join('class cl','cl.id=ad.class_id','left')
				->join('section sec','sec.id=ad.section_id','left')
				->join('personal_details pd','pd.id=st.personal_details_id','left')
				->join('student_house sth','sth.student_id=st.id','left')
				->join('house','house.id=sth.house_id','left');
    }
   
	public function message_list(){
		$query = $this->db->select('msl.id,msl.status,st.student_number,msl.created_at,mn.title message,st.full_name,mobile,class,section,class_roll,house.title house_name')
				->from('message_sent_list msl')		
				->join('message_notification mn','mn.id=msl.message_id','left')
				->join('student_v st','st.id=msl.student_id','left')
				->join('student_house sth','sth.student_id=msl.student_id','left')				
				->join('house','house.id=sth.house_id','left');             
		return $query;
	}
   
	public function message_count(){
		$query = $this->db->select('sh.id')
				->from('message_sent_list msl')		
				->join('student_v st','st.id=msl.student_id','left')
				->join('student_house sth','sth.student_id=msl.student_id','left')				
				->join('house','house.id=sth.house_id','left');
       return $query->count_all_results();
	}
	
	
	function get_student_list($data)
	{
		$this->db->select('st.id,CONCAT(sms_personal_details.first_name," ",sms_personal_details.last_name) as student_name,sms_personal_details.mobile,admission.class_roll,',False);
		$this->db->from('student st');
		$this->db->join('student_house sth','sth.student_id=st.id','left');
		$this->db->join('admission','admission.id=st.admission_id','left');
		$this->db->join('personal_details','personal_details.id=st.personal_details_id','left');
		$this->db->join('class','class.id=admission.class_id','left');
		$this->db->where('st.status_id',1);
		if($data['house_id']>0)
		$this->db->where('sth.house_id',$data['house_id']);
		if($data['facility_id']>0){
		$this->db->where('st.extra_facility_id',$data['facility_id']);
		if($data['facility_id']!=3)
		$this->db->or_where('st.extra_facility_id',3);
		}
		if($data['class_id']>0)
		$this->db->where('admission.class_id',$data['class_id']);
		if($data['section_id']>0)
		$this->db->where('admission.section_id',$data['section_id']);
		$this->db->order_by('admission.class_roll','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}	
	
	function get_student_mobile_no($student_number)
	{
		$this->db->select('sms_personal_details.mobile');
		$this->db->from('sms_student');
		$this->db->join('sms_personal_details','sms_personal_details.id=sms_student.personal_details_id','left');
		$this->db->where('sms_student.id',$student_number);
		$rs=$this->db->get(); 	    
		return $rs->row_array(); 
	}
	
	
	function get_student_info($student_number)
	{
		$this->db->select('s.student_number,pd.mobile,CONCAT(pd.first_name," ",pd.last_name) as student_name,cl.title as class,sec.title as section,ad.class_roll');
		$this->db->from('student s');
		$this->db->join('admission ad','ad.id=s.admission_id','left');
		$this->db->join('class cl','cl.id=ad.class_id','left');
		$this->db->join('section sec','sec.id=ad.section_id','left');
		$this->db->join('personal_details pd','pd.id=s.personal_details_id','left');
		$this->db->where('s.id',$student_number);
		$rs=$this->db->get(); 	    
		return $rs->row_array(); 
	}
	
	
	
	
	function add_sent_message($data)
	{
		$this->db->insert('message_sent_list',$data);
		return $this->db->insert_id();
	}
        
       
      
	
 }

?>