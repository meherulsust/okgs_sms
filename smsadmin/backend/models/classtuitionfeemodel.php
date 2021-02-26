<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 08, 2012
 */
 class Classtuitionfeemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'class_tuition_fee';
    }
   public function get_columns()
   {
   	  return array('id','tuition_fee_head_id','class_id','ammount', 'status','created_at','created_by','updated_at','updated_by');
   }
   
   
   public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('ct.id,ct.ammount,h.title head,c.title class,if(ct.status,"Active","Inactive") status,ct.created_by,ct.created_at',false)
               ->from('class_tuition_fee ct')
               ->join('tuition_fee_head h','ct.tuition_fee_head_id = h.id')
               ->join('class c','ct.class_id = c.id')
               ->order_by('display_order asc');
       
       return $query;
   }
   public function get_info($id){
       $q = $this->info_query();
       $q->select('u.username creator');
       $q->join('user u','u.id = h.created_by','left');
       $q->where('ct.id',$id);
       $query = $q->get();
       return $query->result_array();
   }
   
   public function save($data){
       $ctf_id = parent::save($data);
       $fee_data['class_tuition_fee_id'] = $ctf_id;
       $fee_data['ammount']  = $data['ammount'];
       $fee_data['id']='';
       $this->load->model('classtuitionfeetrailmodel');
       $this->classtuitionfeetrailmodel->save($fee_data);
       return $ctf_id;
   }
   public function cascade_delete($id){
       $this->delete($id);
       $this->load->model('classtuitionfeetrailmodel');
       $this->classtuitionfeetrailmodel->delete_where(array('class_tuition_fee_id'=>$id));
   }
   public function fee_head_exists($class_id,$head_id){
       $id = $this->find_one_by('id', array('class_id'=>$class_id,'tuition_fee_head_id'=>$head_id));
       return $id;
   }
   
	public function get_fees(){
        $sql = $this->db->select('tuition_fee_head_id,class_id,c.ammount,head_type')
                ->from('class_tuition_fee c')
                ->join('tuition_fee_head h','h.id = c.tuition_fee_head_id')
				->where('c.status',1);
        $query = $sql->get();
        return $query->result_array();
	}
   
	public function get_fine(){
        $sql = $this->db->select('tuition_fee_head_id,class_id,c.ammount,head_type')
                ->from('class_tuition_fee c')
                ->join('tuition_fee_head h','h.id = c.tuition_fee_head_id')
				->where('h.head_type','FINE')
                ->where('c.status',1);
        $query = $sql->get();
        return $query->result_array();
	}
  
   
 
 }

?>