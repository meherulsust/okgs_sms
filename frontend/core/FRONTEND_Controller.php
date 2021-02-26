<?php

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 17, 2011
 */
class FRONTEND_Controller extends MT_Controller {

    function __construct() {
        parent::__construct();
        $this->init_template();
        $this->_load_libs();
    }
      protected function init_template() {
        if ($this->input->is_ajax_request()) {
            $this->init_ajax_template();
        } else {
            
			// school info
			$this->load->model('schoolmodel');
			$school_info = $this->schoolmodel->find(1);
			$this->tpl->assign($school_info);
			// set page title
			$this->tpl->set_page_title($school_info['name']);
        }
        return true;
    }

    /*
     *  template initialized in ajax request
     */

    protected function init_ajax_template() {
        $this->tpl->set_layout('ajax_layout');
        return true;
    }
    
    private function _load_libs() {
        $this->load->helper('array');
        $this->load->helper('student');
        
        $this->assign_student_info();
    }
    
    protected function assign_student_info(){
        @$student_number = $this->auth->get_user()->student_number;
        if($student_number){
            $this->load->model('studentvmodel');
            $row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
            $this->tpl->assign($row);
        }
    }

}

?>