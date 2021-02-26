<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 16, 2012
 */
 class Sectiontuitionfeemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'section_tuition_fee';
    }
   public function get_columns()
   {
   	  return array('id','tuition_fee_head_id','section_id','ammount', 'status','created_at','created_by','updated_at','updated_by');
   }
   
   
   public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('st.id,st.ammount,tuition_fee_head_id,h.title head,c.title class, s.title section,if(st.status,"Active","Inactive") status,st.created_by,st.created_at',false)
               ->from('section_tuition_fee st')
               ->join('tuition_fee_head h','st.tuition_fee_head_id = h.id')
               ->join('section s','st.section_id = s.id')
               ->join('class c','s.class_id = c.id')
               ->order_by('display_order asc');
       
       return $query;
   }
   public function get_info($id){
       $q = $this->info_query();
       $q->select('u.username creator');
       $q->join('user u','u.id = h.created_by','left');
       $q->where('st.id',$id);
       $query = $q->get();
       return $query->result_array();
   }
   
   public function get_edit_info($id){
       $q = $this->db->select('st.id,tuition_fee_head_id,st.ammount,section_id,class_id')
             ->from('section_tuition_fee st')
             ->join('tuition_fee_head h','st.tuition_fee_head_id = h.id')
             ->join('section s','st.section_id = s.id')
             ->where('st.id',$id);
       $query = $q->get();
       return $query->row_array();
   }
   
   public function save($data){
       $ctf_id = parent::save($data);
       $fee_data['section_tuition_fee_id'] = $ctf_id;
       $fee_data['ammount']  = $data['ammount'];
       $fee_data['id']  = '';
       $this->load->model('sectiontuitionfeetrailmodel');
       $this->sectiontuitionfeetrailmodel->save($fee_data);
       return $ctf_id;
   }
   public function cascade_delete($id){
       $this->delete($id);
       $this->load->model('sectiontuitionfeetrailmodel');
       $this->sectiontuitionfeetrailmodel->delete_where(array('section_tuition_fee_id'=>$id));
   }
    public function fee_head_exists($section_id,$head_id){
       $id = $this->find_one_by('id', array('section_id'=>$section_id,'tuition_fee_head_id'=>$head_id));
       return $id;
   }
	
	public function get_fee_info(){
		$query = $this->db->select('head_type,tuition_fee_head_id,section_id,f.ammount,class_id')
               ->from('section_tuition_fee f')
               ->join('section s','s.id = f.section_id','left')
               ->join('tuition_fee_head h','h.id = f.tuition_fee_head_id')
			   ->where('f.status',1)
               ->get();
		return $query->result_array();
	}
   
	
	public function get_fine_info(){
		$query = $this->db->select('head_type,tuition_fee_head_id,section_id,f.ammount,class_id')
               ->from('section_tuition_fee f')
               ->join('section s','s.id = f.section_id','left')
               ->join('tuition_fee_head h','h.id = f.tuition_fee_head_id')
			   ->where('h.head_type','FINE')
               ->where('f.status',1)
               ->get();
		return $query->result_array();
	}
	
   
  
   
 
 }

?>