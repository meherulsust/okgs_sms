<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 11, 2012
 * Model class for addressmodel.
 */
class Studenttransfermodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function get_table_name()
   {
   	  return 'student_transfer';
   }
  
   public function get_columns()
   {
   	  return array('id','student_id','reason_id','comments');
   }
   public function grid_query(){
     $this->info_query();
   }
   
   public function get_info($id){
      $query =  $this->db->select('t.id,student_id,student_number,reason_id,t.comments')
               ->from('student_transfer t')
               ->join('student s','s.id = t.student_id','left')
               ->where('t.id',$id)->get();
      return $query->row_array();
   }
   
   public function record_info($id){
       $this->info_query();
       $query = $this->db->where('st.id',$id)->get();
       return $query->row_array();
   }
   
   protected function info_query(){
        $this->db->select('st.id id,student_number,sp.file_name photo,cls.title class,sec.title section,a.class_roll,pd.dob,concat_ws(" ",pd.first_name,pd.last_name) student_name,l.title reason,pd.gender,pd.mobile,concat_ws(" ",gf.first_name, gf.last_name) father_name,concat_ws(" ",gm.first_name, gm.last_name) mother_name,st.created_by, st.created_at,st.comments',false)
               ->from('student_transfer st')
               ->join('student_v s','st.student_id = s.id','left')
               ->join('personal_details pd','pd.student_id = s.id','left')
			   ->join('guardian gf','gf.id = s.father_guardian_id','left')
               ->join('guardian gm','gm.id = s.mother_guardian_id','left')
			   ->join('admission a','a.student_id = s.id','left')
			   ->join('section sec','a.section_id = sec.id','left')
			   ->join('class cls','a.class_id = cls.id','left')
			   ->join('student_photo sp', 'st.student_id = sp.student_id', 'left')
               ->join('lookup l','l.id = st.reason_id','left');
			   
			   
   }
   
   public function get_student_info($id){
       $query = $this->db->select('st.id id,student_number, concat_ws(" ",pd.first_name,pd.last_name) student_name,l.title reason,gender,dob,st.created_by, st.created_at,st.comments
                        ,concat_ws(" ",gf.first_name, gf.last_name) father_name,concat_ws(" ",gm.first_name, gm.last_name) mother_name,cls.title class,sec.title section,class_roll
                        ,address_line,th.name thana, po.name post_office, dst.name district,st.created_at transfer_date',false)
               ->from('student_transfer st')
               ->join('student s','st.student_id = s.id','left')
               ->join('personal_details pd','pd.student_id = s.id','left')
               ->join('guardian gf','gf.id = s.father_guardian_id','left')
               ->join('guardian gm','gm.id = s.mother_guardian_id','left')
               ->join('admission a','a.student_id = s.id','left')
               ->join('section sec','a.section_id = sec.id','left')
               ->join('class cls','sec.class_id = cls.id','left')	
               ->join('address addr','addr.id = s.permanent_address_id','left')
               ->join('post_office po','addr.post_office_id = po.id','left')
               ->join('thana th','th.id = po.thana_id','left')
               ->join('district dst','dst.id = th.district_id','left')
               ->join('lookup l','l.id = st.reason_id','left')
               ->get();
       return $query->row_array();
   }
   
	public function update_status($id,$data)
	{
		$this->db->update('student',$data,array('id'=>$id));
    }
	
	
	public function delete_tc_student($student_id)
	{
		$this->db->delete('student_transfer',array('student_id'=>$student_id));
	}
	

 } 
?>
