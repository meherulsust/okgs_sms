<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 16, 2012
 */
 class Studenttypetuitionfeemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'student_type_tuition_fee';
    }
	
	public function get_columns()
	{
		return array('id','tuition_fee_head_id','student_type_id','class_id','version_id','ammount', 'status','created_at','created_by','updated_at','updated_by');
	}
   
   
	public function grid_query($params){
       $this->info_query();
	}
   
	protected function info_query(){
       $query = $this->db->select('st.id,st.ammount,tuition_fee_head_id,h.title head,stt.title student_type,c.title class,ver.title version,if(st.status,"Active","Inactive") status,st.created_by,st.created_at',false)
               ->from('student_type_tuition_fee st')
               ->join('tuition_fee_head h','st.tuition_fee_head_id = h.id')
               ->join('student_type stt','stt.id = st.student_type_id')
               ->join('class c','st.class_id = c.id')
			   ->join('version_list ver','st.version_id = ver.id','left')
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
		$q = $this->db->select('st.id,tuition_fee_head_id,st.ammount,student_type_id,class_id,version_id')
             ->from('student_type_tuition_fee st')
             ->join('tuition_fee_head h','st.tuition_fee_head_id = h.id')
			 ->join('student_type stt','stt.id = st.student_type_id')
             ->join('class cl','cl.id = st.class_id')
             ->where('st.id',$id);
		$query = $q->get();
		return $query->row_array();
	}
   
	public function save($data){
		$ctf_id = parent::save($data);
		$fee_data['student_type_tuition_fee_id'] = $ctf_id;
		$fee_data['ammount']  = $data['ammount'];
		$fee_data['id']  = '';
		$this->load->model('studenttypetuitionfeetrailmodel');
		$this->studenttypetuitionfeetrailmodel->save($fee_data);
		return $ctf_id;
	}
	public function cascade_delete($id){
		$this->delete($id);
		$this->load->model('studenttypetuitionfeetrailmodel');
		$this->studenttypetuitionfeetrailmodel->delete_where(array('student_type_tuition_fee_id'=>$id));
	}
    public function fee_head_exists($section_id,$head_id){
		$id = $this->find_one_by('id', array('class_id'=>$class_id,'student_type_tuition_fee_id'=>$head_id));
		return $id;
	}
	
	public function get_fee_info($class_id){
		$query = $this->db->select('head_type,tuition_fee_head_id,student_type_id,sf.class_id,sf.version_id,sf.ammount,sec.id section_id')
               ->from('student_type_tuition_fee sf')
               ->join('class c','c.id = sf.class_id','left')
               ->join('section sec','sec.class_id = sf.class_id','left')
			   ->join('tuition_fee_head h','h.id = sf.tuition_fee_head_id')
			   ->where('sf.class_id',$class_id)
			   ->where('sf.status',1)
               ->get();
		return $query->result_array();
	}
   	
	public function get_version_fee_info($class_id){
		$query = $this->db->select('head_type,tuition_fee_head_id,student_type_id,sf.class_id,sf.version_id,sf.ammount,sec.id section_id')
               ->from('student_type_tuition_fee sf')
               ->join('class c','c.id = sf.class_id','left')
			   ->join('section sec','sec.class_id = sf.class_id','left')
			   ->join('tuition_fee_head h','h.id = sf.tuition_fee_head_id')
			   ->where('sf.class_id',$class_id)
			   ->where('sf.status',1)
               ->get();
		return $query->result_array();
	}
	
	public function get_fine_info(){
		$query = $this->db->select('head_type,tuition_fee_head_id,section_id,f.ammount,class_id')
               ->from('student_type_tuition_fee f')
               ->join('section s','s.id = f.section_id','left')
               ->join('tuition_fee_head h','h.id = f.tuition_fee_head_id')
			   ->where('h.head_type','FINE')
               ->where('f.status',1)
               ->get();
		return $query->result_array();
	}
	
   
  
   
 
 }

?>