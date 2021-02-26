<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 09, 2012
 * 
 * admission tuition fee model class
 */
 class Admissionfeemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'admission_tuition_fee';
    }
   public function get_columns()
   {
   	  return array('id','tuition_fee_head_id','admission_id','ammount', 'status','created_at','created_by','updated_at','updated_by');
   }
   
   
   public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('at.id,student_number,tuition_fee_head_id, head_code, session, head_type, concat_ws(" ",first_name,last_name) full_name,at.ammount, h.title,h.description,head_code,if(at.status,"Active","Inactive") status,at.created_by,at.created_at',false)
               ->from('admission_tuition_fee at')
               ->join('admission a','a.id = at.admission_id','left')
               ->join('student s','s.id = a.student_id','left')
               ->join('personal_details p','p.id = s.personal_details_id','left')
               ->join('tuition_fee_head h','at.tuition_fee_head_id = h.id')
               ->order_by('display_order asc');
       
       return $query;
   }
   
   public function get_info($id){
       $q = $this->info_query();
       $q->select('u.username creator');
       $q->join('user u','u.id = h.created_by','left');
       $q->where('at.id',$id);
       $query = $q->get();
       if($query->num_rows()>0){
           $rs = $query->result_array();
           return $rs[0];
       }else{
           return false;
       }
   }
   
   public function save($data){
       $this->load->model('admissionmodel');
       $data['admission_id'] = $this->admissionmodel->get_latest_admission_id(array('student_number'=>$data['student_number']));
       unset($data['student_number']);
       $atf_id = parent::save($data);
       return $atf_id;
   }
   
    public function get_student_fee(){
       $this->load->model('tuitionfeeheadmodel','tfh');
       $common_fee = $this->tfh->get_common();
       $this->load->model('sectiontuitionfeemodel','stf');
       $this->stf->generate_fee();
       
       $student_fee = $common_fee;
       return $student_fee;
   }
   
	public function get_fees(){
        $sql = $this->db->select('tuition_fee_head_id,admission_id,a.ammount,head_type')
                ->from('admission_tuition_fee a')
                ->join('tuition_fee_head h','h.id = a.tuition_fee_head_id')
				->where('a.status',1);
        $query = $sql->get();
        return $query->result_array();
	}
   
	
	public function get_fine(){
        $sql = $this->db->select('tuition_fee_head_id,admission_id,a.ammount,head_type')
                ->from('admission_tuition_fee a')
                ->join('tuition_fee_head h','h.id = a.tuition_fee_head_id')
				->where('h.head_type','FINE')
                ->where('a.status',1);
        $query = $sql->get();
        return $query->result_array();
	}
	
   
 
 }

?>