<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 8, 2012
 * Model class for exam registration .
 */
class Examregistrationmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   
   public function grid_query($params)
   {
   	  $query = $this->get_info_query()
   	  	  ->where('er.exam_id',$params['exam_id']);
          return $query;
   	
   }
   public function total_grid_record($params){
       $query = $this->get_info_query()
   	  	  ->where('er.exam_id',$params['exam_id'])
                  ->get();
       return $query->num_rows();
   }
   
   public function get_info($id){
       $query = $this->get_info_query()->where('er.id',$id)->get();
       return $query->row_array();
       
   }
   
   
   protected function get_info_query(){
       
        $query = $this->db->select('er.id, concat(first_name," ",last_name) student,fee_received,er.status,er.created_at,
                                    er.description,sy.title sylabus, er.updated_at,er.created_by',false)
   	  			->from('exam_registration er')
      	  			->join('admission a','er.admission_id = a.id','left')
                                ->join('sylabus sy','a.sylabus_id = sy.id', 'left')
   	  			->join('student s','a.student_id = s.id','left')
   	  			->join('personal_details pd','s.personal_details_id = pd.id','left');
       return $query;
   }


   
   public function register_student($exam_id)
   {
   	  $this->load->model('examsylabusmodel', 'esmodel');
   	  $sylabus = $this->esmodel->get_field('sylabus_id',array('exam_id'=>$exam_id));
   	  $this->load->model('admissionmodel', 'admodel');
   	  $admission = $this->admodel->admission_by_sylabus($sylabus);
   	  $data = array();
   	 foreach($admission as $i=>$row)
   	 {
   	    $data[$i]['admission_id'] = $row['id'] ;
   	    $data[$i]['fee_received'] = $row['fee'] ;
   	    $data[$i]['exam_id'] =	$exam_id;
   	    $data[$i]['created_at'] = $this->now();
   	    $data[$i]['updated_at'] = $this->now();
   	    $data[$i]['created_by'] = $this->get_created_by();
   	 }
   	 return $this->insert_batch($data);
   }
   
   
   public function save($values)
   {
       //in case of edit
         if($values['id']){
             return parent::save($values); 
         }else{
             $data = array();
             $values['created_by'] = $this->get_created_by();
             foreach($values['admission_id'] as $i=>$admission_id){
                 $data[$i] =$values;  
                 $data[$i]['admission_id'] = $admission_id;
             }
             return $this->insert_batch($data);
         }
   }
   public function get_course_details($id){
       
       $sql =  $this->db->select('r.id, ac.course_id, crst.title course,et.id evaltype_id, et.title eval_type,cset.id cset_id, cset.value full_marks ')
               ->from('exam_registration r')
			   ->join('admission a','r.admission_id = a.id','left')
               ->join('admission_course ac','ac.admission_id = r.admission_id','left')
               ->join('course c','ac.course_id = c.id','left')
               ->join('course_title crst','c.course_title_id = crst.id','left')
               ->join('course_sylabus_evaluation_type cset','ac.course_id = cset.course_id','left')
               ->join('sylabus_evaluation_type syet','cset.sylabus_evaluation_type_id = syet.id','left')
               ->join('evaluation_type et','syet.evaluation_type_id = et.id','left')
               ->where('r.id',$id)
			   ->where('syet.sylabus_id = a.sylabus_id')
               ->order_by('c.serial asc');
       $query = $sql->get();
       return $query->result_array();
   }
   public function get_table_name()
   {
   	  return 'exam_registration';
   }
   public function get_columns()
   {
   	  return array('id','admission_id','exam_id','fee_received','description','status','description','updated_at','created_at','created_by');
   }
   
   public function get_registration_info($id){
      $this->load->model('admissionmodel');
      $sql = $this->admissionmodel->get_student_info_query();
      $query = $sql->select('e.id exam_id, e.title exam_title,gf.first_name f_first_name, gf.last_name f_last_name,gm.first_name m_first_name, gm.last_name m_last_name,h.title house_name')
			  ->join('guardian gf','gf.id = std.father_guardian_id','left')
              ->join('guardian gm','gm.id = std.mother_guardian_id','left')
              ->join('exam_registration er','er.admission_id = a.id','left')
              ->join('exam e','er.exam_id = e.id','left')
			  ->join('student_house sh','sh.student_id = std.id','left')
			  ->join('house h','h.id=sh.house_id','left')
              ->where('er.id',$id)
              ->get();
			  
			//  echo $this->db->last_query();
    return $query->row_array();
   }
   public function get_exam_height_marks($exam_id){
			  $this->db->select('max(obtain_marks) height_mark')
			  ->from('exam_result er')
			  ->join('exam_registration reg','reg.id = er.exam_registration_id','left')
			  ->where('exam_id',$exam_id);	  
		return $this->get_one();
   }
  
    

 } 
?>
