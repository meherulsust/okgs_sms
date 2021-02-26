<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     September 01, 2012
 */
 class Tuitionfeeheadmodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'tuition_fee_head';
    }
   public function get_columns()
   {
   	  return array('id','title','fund_id','head_type','head_code','display_order','is_common','status','created_at','created_by','ammount','description');
   }
   
   
   public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('h.id,ammount,h.title,description,head_type,head_code,if(h.status,"Active","Inactive") status,h.created_by,h.created_at,fl.title fund',false)
               ->from('tuition_fee_head h')
			   ->join('fund_list fl','fl.id=h.fund_id')
               ->order_by('display_order asc');
       
       return $query;
   }
   public function get_info($id){
       $q = $this->info_query();
       $q->select('u.username creator');
	   $q->join('user u','u.id = h.created_by','left');
       $q->where('h.id',$id);
       $query = $q->get();
       return $query->result_array();
   }
   
   public function find_by_code($code){
        return $this->find_row(array('head_code'=>$code));
    }
    
    public function get_common(){
        return $this->select_where('id,head_type,title,ammount,display_order',array('is_common'=>1,'status'=>1));
    }
	
	public function get_fine(){
        return $this->select_where('id,head_type,title,ammount,display_order',array('is_common'=>1,'status'=>1,'head_type'=>'FINE'));
    }
	
 
	public function get_all_head()
	{
		$this->db->select('id,title,ammount,head_type');
		$this->db->from('tuition_fee_head');
		$this->db->where('status',1);
		$this->db->order_by('display_order','ASC'); 
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
 
 }

?>