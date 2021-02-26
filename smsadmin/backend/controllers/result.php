<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 12, 2013
 */
class Result extends BACKEND_Controller{
    function __construct()
    {
		parent::__construct();
		$this->tpl->set_page_title('Exam result');
    }
    function save($reg_id){
         $this->output->set_content_type('application/json');
         $response = array('success' => 1,'message'=>'Result has been saved successfully.');
         $this->load->model('courseresultmodel','crmodel'); 
         $this->crmodel->save_result($reg_id);
         $this->output->set_output(json_encode($response));
    }
    function update($reg_id){
         $this->output->set_content_type('application/json');
         $response = array('success' => 1,'message'=>'Result has been updated successfully.');
         $this->load->model('courseresultmodel','crmodel'); 
         $this->crmodel->update_result($reg_id);
         $this->output->set_output(json_encode($response));
    }
    
}
?>
