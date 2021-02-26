<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 25, 2012
 * 
 * course type evaluation rule class
 */
 require_once dirname(__FILE__).'/evaluationrule.php';
 class Coursetyperule extends Evaluationrule{
     
     protected function init_rule($sylabus_course_type_id){
         if(empty($this->rules)){
             $this->CI->load->model('sylabuscoursetypemodel','sctmodel');
             $this->rules = $this->CI->sctmodel->get_sylabus_course_type_attribute($sylabus_course_type_id);
             if(empty($this->rules)){
                 $this->rules = false;
                 return true;
             }else{
                 $this->rules = array_group_by_key($this->rules, 'sylabus_course_type_id');
             }
         }
     }
     
     public function evalueate($row,$sylabus_course_type_id){
      if($this->rules === false){
          return $row;
      }
      $this->init_rule($sylabus_course_type_id);
      if(isset($this->rules[$row['course_type']])){
           foreach($this->rules[$row['course_type']] as $rule){
                if(method_exists($this, $rule['eval_func'])){
                    $row = $this->$rule['eval_func']($row,$rule['params']);
                }   
            }
      }
     
      return $row;
  }
  
  
  protected function subtract_additional_score($row,$params){
      switch($row['scale_code']){
          case 'GRADE':
            $row['additional_weight'] = $row['weight'] - (int) $params;
            $row['additional_weight'] = ($row['additional_weight'] > 0)? $row['additional_weight']:0;
            $row['additional_marks'] = $row['obtain_marks'];
            break;
          case 'DIVISION':
            $row['additional_weight'] = $row['weight'];
            $row['additional_marks'] = $row['obtain_marks'] - (int) $params;
            $row['additional_marks'] = ($row['additional_marks'] > 0)? $row['additional_marks']:0;
            break;
      }
      $row['is_additional'] = true;
      $row['score_subtract'] = $params;
      return $row;
  }
  protected function require_pass($row,$params){
     $row['require_pass'] = true;
     if(!$row['is_pass'])
     $this->CI->erdmodel->set_final_result(array('is_pass'=>false));
     return $row;
  }
 }
?>
