<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    Oct 05, 2015
 */
 class Unpaid_smsmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
    public function get_columns()
	{
   	  return array('id');
    }
	 public function get_table_name()
    {
   	 return 'student_tution_fee_payment_message';
    }	
   
   public function grid_query(){
        $this->db->select('st.id id,st.status,st.year,st.month,sv.student_number,sv.class,sv.class_roll,st.mobile_no,concat_ws(" ",sv.first_name,sv.last_name) student_name,st.date',false)
               ->from('student_tution_fee_payment_message st')
               ->join('student_v sv','sv.id=st.student_id','left');
    }
	
	public function get_unpaid_info($data){
		$this->db->select('t.student_id,sv.mobile,sv.class_id,sv.full_name')
			   ->from('student_tuition_fee_payment t')
			   ->join('student_v sv','t.student_id = sv.id','left')
			   ->where('t.year',$data['year'])
			   ->where('t.month',$data['month'])
    	       ->where('t.pay_status','UNPAID');
				if($data['class']!=''){
				$this->db->where('sv.class_id',$data['class']);
				}
				$query = $this->db->get();
				$rs = $query->result_array();
				return $rs;
			}
	public function save_data($data){
				$this->db->insert('student_tution_fee_payment_message', $data);
			}	

 }
 

?>