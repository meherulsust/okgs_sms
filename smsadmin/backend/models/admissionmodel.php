<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 27, 2012
 * 
 * model class for admission
 */
 class Admissionmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'admission';
   }
   public function grid_query($params)
   {
   	  $query = $this->get_info_query();
   	  $query->where('student_id',$params['student_id']);
   	  return $query;
   }
   
   public function save($data)
   {
   	 if(!$data['sylabus_id'])
   	  	$data['sylabus_id'] = $this->get_active_sylabus($data['class_id'],$data['section_id']);
   	  	
   	  return parent::save($data);
   }
   protected function get_active_sylabus($class_id,$section_id)
   {
   	
   	 $sql = $this->db->select('id')
   	  			->from('sylabus s')
   	  			 ->where("(class_id = '$class_id' AND status = 'ACTIVE')  AND ( section_id = '0' or section_id = '$section_id' ) ");
   	  			 
   	 return $this->get_one();		
   }
   
   public function get_info($id)
   {
   		$query = $this->get_info_query();
   		$query->where('a.id',$id);
   		$rs = $query->get();
   		return $rs->row_array();
   }
   public function get_columns()
   {
   	  return array('id','student_id','student_type_id','class_id','section_id','sylabus_id','session','class_roll','board_roll','board_regino','index_no','birth_regino','fee','status','comments','created_at','created_by');
   } 
   
   public function get_by_course($course_id)
   {
   	 $sql = $this->db->select('cset.id,sylabus_evaluation_type_id,value,et.title,eval_type')
   	 		  ->from($this->get_table_name().' cset')
   	 		  ->join('sylabus_evaluation_type st','st.id = cset.sylabus_evaluation_type_id','left')
   	 		  ->join('evaluation_type et','et.id = st.evaluation_type_id','left')
   	 		  ->where('course_id',$course_id);
   	$query = $sql->get(); 
   	return $query->result_array();
   }
   
   protected function get_info_query()
   {
   		$query = $this->db->select('a.id,a.student_type_id,c.title class, sylabus_id, student_id,section_id, s.title section, s.class_id, session, a.status, class_roll, board_roll, board_regino,index_no,birth_regino,comments, fee, a.created_at, u.full_name created_by,stt.title student_type')
    			 ->from('admission a')
    			 ->join('student_type stt','stt.id = a.student_type_id','left')
				 ->join('class c','a.class_id = c.id','left')
    			 ->join('section s','a.section_id = s.id','left')
                 ->join('user u','a.created_by = u.id','left');
    	return $query;         
   }
   
   public function get_course($admission_id)
   {
   	   $sql = $this->db->select('course_type_id, ct.title course_type, crst.title, c.code, c.id')
    			 ->from('course c')
                     ->join('course_title crst','crst.id = c.course_title_id', 'left')
    	         ->join('sylabus_course_type sct','sylabus_course_type_id = sct.id', 'left')
    	         ->join('course_type ct','course_type_id = ct.id', 'left')
    	         ->join('admission a','a.sylabus_id = c.sylabus_id','left')
    	         ->where("a.id = '$admission_id'");
    	         $query = $sql->get();     
    	return $query->result_array();  
   }
   
   public function get_course_type($admission_id)
   {
   	    $sql = $this->db->select('course_type_id id, ct.title ')
    			 ->from('sylabus_course_type sct')
    	         ->join('course_type ct','course_type_id = ct.id', 'left')
    	         ->join('admission a','a.sylabus_id = sct.sylabus_id','left')
    	         ->where("a.id = '$admission_id'")
    	         ->order_by('title asc');
        $rs = $this->get_list();
     return $rs;  
   }
   
   public function is_roll_exist($id,$roll_no,$session,$class_id,$section_id)
   {
   	    $query = $this->db->select('id')
   	    		 ->from('admission')
   	    		 ->where("class_roll = '$roll_no' AND session='$session' AND class_id ='$class_id' AND ( section_id = '0' or section_id = '$section_id' ) ")
   	             ->get(); 
   	   if( $query->num_rows() > 0 )
   	   {
   	   	    $row  = $query->row_array();
   	   	    // check for edit
   	   	    if($id && $row['id'] == $id)
   	   	    return false;
   	   	    else
   	   		return true;
   	   }	
   	   else
   	   return false;          
   }
   
   public function admission_by_sylabus($sylabus_id)
   {
   	 $sql = $this->db->select('id,fee')->from($this->get_table_name());
   	 if(is_array($sylabus_id))
   	 $sql->where_in('sylabus_id',$sylabus_id);
   	 else
   	 $sql->where('sylabus_id',$sylabus_id);
   	 $query = $sql->get();
   	 return $query->result_array();
   }
   public function get_student_info($admission_id){
                $sql = $this->get_student_info_query();
    	        $query = $sql->where('a.id', $admission_id)
                        ->get();      
        return $query->row_array();
   }
   public function get_student_info_query(){
        $query = $this->db->select('student_number,c.title class,s.title section,p.first_name,p.last_name,blg.symbol blood_group,photo_id,file_name,dob,class_roll,stt.title student_type,f.first_name f_first_name, f.last_name f_last_name,m.first_name m_first_name, m.last_name m_last_name')
    			 ->from('admission a')
                 ->join('student std','std.id = a.student_id', 'left')
				 ->join('guardian f','f.id = std.father_guardian_id','left')
				 ->join('guardian m','m.id = std.mother_guardian_id','left')	
				 ->join('personal_details p','personal_details_id = p.id','left')
				 ->join('blood_group blg','blg.id = p.blood_group_id','left')
                 ->join('student_photo sp','photo_id = sp.id','left')
    	         ->join('section s','s.id = a.section_id', 'left')
    	         ->join('class c','c.id = s.class_id','left')
				 ->join('student_type stt','stt.id = a.student_type_id','left');
        return $query;
   }
   public function is_admission_exists($id,$student_id,$session){
          $rec_id = $this->find_one_by('id',array('student_id'=>$student_id,'session' => $session, 'status' => 'ACTIVE'));
          if($id){
           //editing same record
           if($rec_id == $id)
               return false;
           elseif($rec_id)
               return true;
           else
               return false;
       }else{
           if($rec_id)
               return true;
           else
               return false;
       }
       
   }
   public function get_latest_admission_id($where){
       $query = $this->db->select('a.id')
               ->from('admission a')
               ->join('student s','s.id = a.student_id','left')
               ->where($where)
               ->order_by('a.id desc')
               ->limit(1)
               ->get();
       if($query->num_rows() > 0){
           $row = $query->result_array();
           return $row[0]['id'];
       }else{
           return false;
       }
   }
   
   public function get_current_student_list($section_id){
       $data = array();
       $query = $this->db->select('a.id,student_number,first_name,last_name')
    	         ->from('admission a')
                 ->join('student std','std.id = a.student_id', 'left')
                 ->join('personal_details p','personal_details_id = p.id','left')
    	         ->where('a.section_id', $section_id)
                 ->where('a.session',date('Y'))
                ->get();
       if($query->num_rows()>0){
            $rs = $query->result_array();
            foreach($rs as $row){
                $title = trim($row['first_name'].' '.$row['last_name']);
                $title .= '('.$row['student_number'].')';
                $data[] = array('id'=>$row['id'],'title'=>$title);
            }
       }
       return $data;
   }
   
   

   
  
 }

?>