<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
 class Usermodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
  
    public function get_columns()
   {
   	  return array('id','username','user_group_id','passwd','email','mobile','address','mobile_no','full_name','status','created_at','created_by');
   }
  
   public function get_table_name()
   {
   	 return 'user';
   }
   public function has_same_password($user_id,$password){
       $row = $this->find($user_id);
       return ($password == $row['passwd']);
       
   }
   public function update_password($id,$password){
       return $this->update_fields(array('passwd'=>$password),$id);
   }
   
   public function get_info($id){
       $query = $this->db->select('u.id,username,full_name,g.title group_name ,mobile_no,address,email,u.created_at')
               ->from('user u')
               ->join('user_group g','g.id = u.user_group_id','left')
               ->where('u.id', $id)
               ->get();
      if($query->num_rows() > 0){
          return $query->row_array();
      }
      return false;
   }
   
	public function allstudentuser()
	{
		$this->db->select('id,username');
        $this->db->from('user'); 
		$this->db->where('user_group_id',4);	
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
	
	public function update_student_user($user_id,$data)
	{
		$this->db->update('user',$data,array('id'=>$user_id));
	}
	
 }

?>