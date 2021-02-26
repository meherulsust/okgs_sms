<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 14, 2012
 */
class Examresultdetailsmodel extends BACKEND_Model {

    protected $final_result = array('scale_code' => '', 'scale_matrix_id' => 0, 'total_obtain_weight' => 0, 'weight' => 0, 'additional_weight' => false, 'additional_marks' => false, 'weight_with_additional' => false, 'title' => false, 'obtain_marks_with_additional' => false, 'full_marks' => 0, 'is_pass' => true, 'obtain_marks' => 0, 'total_course' => 0, 'additional_marks' => false, 'additional_marks' => false);

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'exam_result_details';
    }

    public function get_columns() {
        return array('id', 'course_sylabus_evaluation_type_id', 'exam_registration_id', 'obtain_marks', 'created_at');
    }

    public function save($data) {
        $records = array();
        $updates = array();
        $dels = array();
        $old_records = $this->get_where(array('exam_registration_id' => $data['reg_id']));
        $i = 0;
        foreach ($old_records as $row) {
            if (isset($data['result'][$row['course_sylabus_evaluation_type_id']])) {
                $nrow = $data['result'][$row['course_sylabus_evaluation_type_id']];
                if ($nrow['marks'] != $row['obtain_marks']) {
                    $updates[$i]['obtain_marks'] = $nrow['marks'];
                    $updates[$i]['updated_at'] = $this->now();
                    $updates[$i]['id'] = $row['id'];
                }
                unset($data['result'][$row['course_sylabus_evaluation_type_id']]);
            } else {
                $dels[] = $row['id'];
            }
        }
        if ($data['result']) {
            $records = $this->_process_record($data);
            $this->insert_batch($records);
        }
        if ($updates)
            $this->update_batch($updates);
        if($dels)
            $this->delete_batch($dels);
        return true;
    }

    private function _process_record($data) {
        $i = 0;
        $records = array();
        foreach ($data['result'] as $cset_id => $row) {
            $records[$i]['course_sylabus_evaluation_type_id'] = $cset_id;
            $records[$i]['exam_registration_id'] = $data['reg_id'];
            $records[$i]['obtain_marks'] = $row['marks'];
            $records[$i]['created_at'] = $this->now();
            $records[$i]['created_by'] = $this->get_created_by();
            $records[$i]['updated_at'] = $this->now();
            $i++;
        }
        return $records;
    }

    public function get_result($reg_id) {
        $sql = $this->db->select('exam_id, course_id, c.sylabus_id,c.sylabus_course_type_id,c.total_marks, percent_to_pass, crst.title course,et.id evaltype_id, et.title eval_type,cset.id cset_id,r.obtain_marks, cset.value full_marks,result_scale_id ')
                ->from('exam_result_details r')
                ->join('course_sylabus_evaluation_type cset', 'r.course_sylabus_evaluation_type_id = cset.id', 'left')
                ->join('course c', 'cset.course_id = c.id', 'left')
                ->join('course_title crst', 'c.course_title_id = crst.id', 'left')
                ->join('sylabus s', 'c.sylabus_id = s.id', 'left')
                ->join('sylabus_evaluation_type syet', 'cset.sylabus_evaluation_type_id = syet.id', 'left')
                ->join('evaluation_type et', 'syet.evaluation_type_id = et.id', 'left')
				->join('exam_registration reg', 'reg.id = r.exam_registration_id', 'left')
                ->where('r.exam_registration_id', $reg_id);
        $query = $sql->get();
        return $this->_process_result($query->result_array());
    }

    public function scale_matrix_evaluation($sylabus_id, $marks) {
        if (empty($this->scale_matrix)) {
            $this->load->model('sylabusmodel', 'smodel');
            $this->scale_matrix = $this->smodel->get_result_scale_matrix($sylabus_id);
        }
        foreach ($this->scale_matrix as $row) {
            if ($marks >= $row['min_range'] && $marks <= $row['max_range']) {
                break;
            }
        }
        return $row;
    }

    public function final_evaluation_by_weight($weight) {
        if ($this->scale_matrix) {
            foreach ($this->scale_matrix as $row) {
                if ($row['weight'] <= $weight) {
                    break;
                }
            }
        }
        return $row;
    }

    public function final_evaluation_by_marks($marks) {
        if ($this->scale_matrix) {
            foreach ($this->scale_matrix as $row) {
                if ($marks >= $row['min_range'] && $marks <= $row['max_range']) {
                    break;
                }
            }
        }
        return $row['title'];
    }

    private function _process_result($results) {
        $processed_results = array();
        if ($results) {
            $sylabus_id = $results[0]['sylabus_id'];
            foreach ($results as $row) {
                if (!isset($processed_results[$row['course_id']])) {
                    $processed_results[$row['course_id']] = array('course' => $row['course'], 'full_marks' => $row['total_marks'], 'percent_to_pass' => $row['percent_to_pass'], 'course_type' => $row['sylabus_course_type_id']);
                    $processed_results[$row['course_id']]['obtain_marks'] = $row['obtain_marks'];
					$processed_results[$row['course_id']]['height_marks'] = $this->get_course_height_marks($row['exam_id'],$row['course_id']);
                } else {
                    $processed_results[$row['course_id']]['obtain_marks'] += $row['obtain_marks'];
                }
                $is_pass = $this->_is_pass_marks($row['obtain_marks'], $row['full_marks'], $row['percent_to_pass']);
                $processed_results[$row['course_id']]['eval_types'][] = array('title' => $row['eval_type'], 'full_marks' => $row['full_marks'], 'obtain_marks' => $row['obtain_marks'], 'is_pass' => $is_pass);
            }
            $this->load->library('rule/sylabusrule');
            $this->load->library('rule/coursetyperule');
            foreach ($processed_results as &$row) {
                $percent = $row['obtain_marks'] * 100 / $row['full_marks'];
                $row['obtain_percent'] = ceil($percent);
                $scale = $this->scale_matrix_evaluation($sylabus_id, $row['obtain_percent']);
                $this->final_result['scale_code'] = $scale['code_name'];
                $row['title'] = $scale['title'];
                $row['scale_matrix_id'] = $scale['scale_matrix_id'];
                $row['weight'] = $scale['weight'];
                $row['scale_code'] = $scale['code_name'];
                $row['require_pass'] = true;
                $row['is_pass'] = ($row['obtain_percent'] >= $row['percent_to_pass']);
                //apply course type rule for the sylabus
                $row = $this->coursetyperule->evalueate($row, $sylabus_id);
                //apply sylabus rule.
                $row = $this->sylabusrule->evalueate($row, $sylabus_id);
                if (isset($row['is_additional'])) {
                    $this->final_result['additional_weight'] = $row['additional_weight'];
                    $this->final_result['additional_marks'] = $row['additional_marks'];
                } else {
                    $this->final_result['total_course'] += 1;
                    $this->final_result['total_obtain_weight'] += $scale['weight'];
                    $this->final_result['obtain_marks'] += $row['obtain_marks'];
                    $this->final_result['full_marks'] += $row['full_marks'];
                }
            }
            $this->final_result['weight'] = round($this->final_result['total_obtain_weight'] / $this->final_result['total_course'], 1);
            if ($this->final_result['additional_weight'] !== false) {
                $this->final_result['weight_with_additional'] = (float) (($this->final_result['total_obtain_weight'] + $this->final_result['additional_weight']) / $this->final_result['total_course']);
                $this->final_result['obtain_marks_with_additional'] = (int) ($this->final_result['obtain_marks'] + $this->final_result['additional_marks']);
            }
            // determine by dynamic attribute function.
			$this->final_result['result_scale_id']	=  $results[0]['result_scale_id'];
            switch ($this->final_result['scale_code']) {
                case 'GRADE':
                    $weight = $this->final_result['weight_with_additional'] ? $this->final_result['weight_with_additional'] : $this->final_result['weight'];
                    $fscale = $this->final_evaluation_by_weight($weight);
					$this->final_result['title'] = $this->final_result['is_pass']? $fscale['title']: "F";
					$this->final_result['weight'] = $this->final_result['is_pass']?  $this->final_result['weight']: "0.00";
                    //$this->final_result['title'] = $fscale['title'];
                    $this->final_result['scale_matrix_id'] = $fscale['scale_matrix_id'];
                    break;
                case 'DIVISION':
                    $marks = $this->final_result['obtain_marks_with_additional'] ? $this->final_result['obtain_marks_with_additional'] : $this->final_result['obtain_marks'];
                    $percent_marks = $marks * 100 / $this->final_result['full_marks'];
                    $fscale = $this->final_evaluation_by_marks($percent_marks);
                    $this->final_result['title'] = $fscale['title'];
                    $this->final_result['scale_matrix_id'] = $fscale['scale_matrix_id'];
                    break;
            }
            return $processed_results;
        } else {
            return $results;
        }
    }

    private function _is_pass_marks($obtain_marks, $full_marks, $percent_to_pass) {
        $percent = $obtain_marks * 100 / $full_marks;
        if ($percent < $percent_to_pass) {
            return false;
        } else {
            return true;
        }
    }

    public function set_final_result($result_row) {
        $this->final_result = array_merge($this->final_result, $result_row);
    }

    public function get_final_result() {
        return $this->final_result;
    }
	
	public function get_course_height_marks($exam_id,$course_id){
		$this->db->select('max(obtain_percent)')
		->from('exam_course_result cr')
		->join('exam_registration reg','reg.id = cr.exam_registration_id','left')
	    ->where('exam_id',$exam_id)
		->where('course_id',$course_id);
		return $this->get_one();
	}
	/* public function all_students_result_info12($data='')
	{
		$this->db->select('er.id erg_id');
        $this->db->from('admission a');
        $this->db->join('exam_registration er', 'er.admission_id = a.id','right');                               
        $this->db->where('a.class_id',$data['class_id']);
		if($data['section_id']>0){
		$this->db->where('a.section_id',$data['section_id']);   
		}	
		$this->db->order_by('a.class_roll','ASC');
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	} */
	
	public function all_students_result_info($exam_id)
	{
		$this->db->select('er.id');
        $this->db->from('exam_registration er');
		$this->db->where('er.exam_id',$exam_id);          
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
	
	public function student_result_info($student_id,$exam_id)
	{
		$this->db->select('er.id');
        $this->db->from('exam_registration er');
		$this->db->join('student s','s.admission_id=er.admission_id','right');         
		$this->db->where('s.id',$student_id); 
		$this->db->where('er.exam_id',$exam_id);		
		$query = $this->db->get();
		$rs = $query->result_array();
		return $rs;
	}

}

?>