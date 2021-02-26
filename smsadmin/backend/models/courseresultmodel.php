<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 13, 2013
 * 
 * model class for course result
 */
class Courseresultmodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'exam_course_result';
    }

    public function get_columns() {
        return array('id', 'exam_registration_id', 'course_id', 'obtain_percent', 'scale_matrix_id', 'created_at', 'updated_at', 'updated_by', 'created_by');
    }

    public function save_result($reg_id) {
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $results = $this->erdmodel->get_result($reg_id);
        $final_result = $this->erdmodel->get_final_result();
        $this->db->trans_start();
        $this->insert_batch($this->_prepare_result($results, $reg_id));
        $this->load->model('examresultmodel', 'ermodel');
        $final_result['id'] = '';
        $this->ermodel->save($this->_prepare_final_result($final_result, $reg_id));
        $this->db->trans_complete();
    }

    private function _prepare_result($results, $reg_id) {
        $data = array();
        $i = 0;
        foreach ($results as $course_id => $result) {
            $data[$i]['exam_registration_id'] = $reg_id;
            $data[$i]['course_id'] = $course_id;
            $data[$i]['scale_matrix_id'] = $result['scale_matrix_id'];
            $data[$i]['obtain_percent'] = $result['obtain_percent'];
            if (isset($result['id'])) {
                $data[$i]['id'] = $result['id'];
                $data[$i]['updated_by'] = $this->get_created_by();
                $data[$i]['updated_at'] = $this->now();
            } else {
                $data[$i]['created_by'] = $this->get_created_by();
                $data[$i]['updated_by'] = $this->get_created_by();
                $data[$i]['created_at'] = $this->now();
                $data[$i]['updated_at'] = $this->now();
            }
            $i++;
        }
        return $data;
    }

    private function _prepare_final_result($final_result, $reg_id) {
        $data['scale_matrix_id'] = $final_result['scale_matrix_id'];
        $data['exam_registration_id'] = $reg_id;
        $data['weight'] = $final_result['weight'];
        $data['obtain_marks'] = $final_result['obtain_marks'];
        $data['additional_weight'] = is_numeric($final_result['additional_weight']) ? $final_result['additional_weight'] : null;
        $data['additional_marks'] = is_numeric($final_result['additional_marks']) ? $final_result['additional_marks'] : null;
        if ($final_result['id']) {
            $data['updated_at'] = $this->now();
            $data['updated_by'] = $this->get_created_by();
            $data['id'] = $final_result['id'];
        } else {
            $data['created_at'] = $this->now();
            $data['updated_at'] = $this->now();
            $data['created_by'] = $this->get_created_by();
            $data['updated_by'] = $this->get_created_by();
        }

        return $data;
    }

    public function update_result($reg_id) {
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $results = $this->get_where(array('exam_registration_id' => $reg_id));
        $new_results = $this->erdmodel->get_result($reg_id);
        $new_final_result = $this->erdmodel->get_final_result();
        $changed_results = array();
        $old = array();
        foreach ($results as $i => $row) {
            if (isset($new_results[$row['course_id']])) {
                if ($new_results[$row['course_id']]['obtain_percent'] != $row['obtain_percent']) {
                    $changed_results[$row['course_id']] = $new_results[$row['course_id']];
                    $changed_results[$row['course_id']]['id'] = $row['id'];
                }
                unset($new_results[$row['course_id']]);
            } else {
                $old[] = $row['id'];
            }
        }
        if ($changed_results) {
            $data = $this->_prepare_result($changed_results, $reg_id);
            $this->update_batch($data);
        }
        if ($old) {
            $this->delete_batch($old);
        }
        if ($new_results) {
            $data = $this->_prepare_result($new_results, $reg_id);
            $this->insert_batch($data);
        }
        $this->load->model('examresultmodel', 'ermodel');
        $final_result = $this->ermodel->get_where(array('exam_registration_id' => $reg_id));
        $new_final_result['id'] = $final_result[0]['id'];
        $fresult = $this->_prepare_final_result($new_final_result, $reg_id);
        $this->ermodel->save($fresult);
    }

}

?>