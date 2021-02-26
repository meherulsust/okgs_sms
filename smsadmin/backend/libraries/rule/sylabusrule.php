<?php

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 25, 2012
 * 
 * sylabus evaluation rule class
 */
require_once dirname(__FILE__) . '/evaluationrule.php';

class Sylabusrule extends Evaluationrule {

    protected function init_rule($sylabus_id) {
        if (empty($this->rules)) {
            $this->CI->load->model('sylabuscourseattributemodel', 'scamodel');
            $this->rules = $this->CI->scamodel->get_sylabus_attribute($sylabus_id);
            if (empty($this->rules)) {
                $this->rules = false;
                return true;
            }
        }
    }

    public function evalueate($row, $sylabus_id) {
        if ($this->rules === false) {
            return $row;
        }
        $this->init_rule($sylabus_id);
        if ($this->rules) {
            foreach ($this->rules as $rule) {
                if (method_exists($this, $rule['eval_func'])) {
                    $row = $this->$rule['eval_func']($row, $rule['params']);
                }
            }
        }

        return $row;
    }

    public function is_pass_to_each_eval($row, $params) {
        if ($row['require_pass']) {
            foreach ($row['eval_types'] as $eval) {
                if ($eval['is_pass'] == false) {
                    $row['is_pass'] = false;
                    $row['title'] = 'F';
                    $row['weight'] = '0';
                    break;
                }
            }
            if ($row['is_pass'] === false) {
                $this->CI->erdmodel->set_final_result(array('is_pass' => false));
            }
        }
        return $row;
    }

}

?>
