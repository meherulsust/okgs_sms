<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 06, 2012
 * Model class for exam.
 */
class Exammodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'exam';
   }
  public function get_info($id)
  {
  	 $sql = $this->db->select('e.id, e.title exam, l.title exam_type,unique_code lookup_code,fee,e.description,e.status,is_final,exam_session,
  	 			c.title class,s.title section,e.created_at,e.created_by')
  	 		  ->from('exam e')
                          ->join('lookup l','l.id = exam_type_lookup_id', 'left')
  	 		  ->join('section s','s.id = e.section_id','left')
  	 		  ->join('class c', 'c.id = e.class_id','left')
  	 		  ->where('e.id',$id);
  	 		  
  	 $query  = $sql->get();
  	 return $query->row_array();		  
  }
  public function save($data)
  {
  	   $sylabus_id  = $data['sylabus_id'];
       $this->db->trans_start();
       $sylabus = array();
       $this->load->model('examsylabusmodel','esm');
       //case of edit
       if($data['id'])
       {
       	  $old_sylabus = $this->esm->get_field('sylabus_id',array('exam_id'=>$data['id']));
       	  $diff_sylabus = array_diff($old_sylabus,$sylabus_id);
       	  if($diff_sylabus)
       	  {
       	  	$this->db->where_in('sylabus_id', $diff_sylabus)->delete('exam_sylabus');
       	  }
       	  $intersect_sylabus =  array_intersect($old_sylabus,$sylabus_id);
       	  
       }
       $exam_id = parent::save($data);
       foreach($sylabus_id as $i=>$sid)
       {
       	 if(isset($intersect_sylabus) && in_array($sid,$intersect_sylabus))
       	 	continue;
       	 $sylabus[$i]['exam_id'] = $exam_id;
       	 $sylabus[$i]['sylabus_id'] = $sid;
       	 $sylabus[$i]['created_at'] = $this->now();
       	 $sylabus[$i]['created_by'] = $this->get_created_by();
       }
       if($sylabus)
       $this->esm->insert_batch($sylabus);
       
       $this->db->trans_complete();
       return $exam_id;
       
  }
  
  public function get_admission_list($params)
  {
  	$this->load->model('examsylabusmodel','esm');
  	$sylabus = $this->esm->get_field('sylabus_id',array('exam_id'=>$params['exam_id']));
  	$query = $this->db->select('a.id ,concat_ws(" ",first_name,last_name) title', false)
  					->from('admission a')
  					->join('exam_registration er','er.admission_id = a.id','left')
  					->join('student s','a.student_id = s.id','left')
   	  				->join('personal_details pd','s.personal_details_id = pd.id','left')
   	  				->where_in('a.sylabus_id',$sylabus)
   	  				->where('er.admission_id is null');
   	return $query->get(); 			
  }
  
  public function delete($id)
  {
  	$this->load->model('examsylabusmodel','esm');
  	$this->esm->delete_where(array('exam_id'=>$id));
  	parent::delete($id);
  }
  
  public function get_columns()
   {
   	  return array('id','class_id','section_id','fee','is_final', 'description','title','status','start_date', 'end_date', 
   	 'exam_type_lookup_id', 'exam_controller','exam_session' ,'created_at','created_by');
   }
    public function edit_exam($exam_id, $data) {
        return $this->db->update('exam', $data, array('id' => $exam_id));
    }
 } 
?>