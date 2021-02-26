<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    Oct 04, 2015
 */
 class Unpaid_sms extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->filter('unpaid_message_filter', 'upm');
		$this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'unpaid_sms'));
		$this->init_grid();		
	}
   
    protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Unpaid SMS List');
	   $this->grid_board->set_filter($this->upm);
	   $actions = array(
						'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete SMS'),
						);
	   $this->grid_board->set_action($actions);
       $this->grid_board->add_link('Send Unpaid SMS',site_url('unpaid_sms/create'),array('class'=>'add'));
	   $grid_columns =  $grid_columns = array('id' => array('visible' => false), 'student_number' => 'Student ID', 'student_name' => 'Student Name',
            'mobile_no' => 'Mobile','class'=>'Class','class_roll'=>'Roll','date' => 'Create Date','year'=>'Year','month'=>'Month','status'=>'Status');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('unpaid_smsmodel');
	}
	
	
    public function filter() {
        $this->load->filter('unpaid_message_filter', 'upm');
        $this->upm->execute();
        redirect('unpaid_sms');
    }
	
    public function create() {
        $this->load->form('unpaid_smsform', 'upmform');
    }
    public function save(){
		$this->load->form('unpaid_smsform','upmform');
		$this->tpl->set_view('create');
		$this->process_form($this->upmform);
		
	}
  
    public function del($id)
	{
		$this->load->model('unpaid_smsmodel','bsmodel');
		$this->bsmodel->delete($id);
		$this->session->set_flashdata('success',"SMS been deleted successfully.");
		redirect('unpaid_sms');
	}
	protected function process_form($form)
	{
		$this->load->model('unpaid_smsmodel');
		if($form->validate())
		{	
			$data['year'] = $this->input->post('unpaid_sms_year');		
			$data['month'] = $this->input->post('unpaid_sms_month');		
			$data['class'] = $this->input->post('unpaid_sms_class_id');
			$get_info =$this->unpaid_smsmodel->get_unpaid_info($data);
			$month_name =date("F", mktime(0, 0, 0, $data['month'], 10));
                        
			foreach($get_info as $val){
                            $data['year'] = $this->input->post('unpaid_sms_year');		
                            $data['month'] = $this->input->post('unpaid_sms_month');
                            $data['class'] = $val['class_id'];
                            $data['student_id'] = $val['student_id'];	
                            $data['mobile_no'] = '880'.substr($val['mobile'],-10);		
                            $data['date'] = date('Y-m-d H:i:s');
                            
                            $gsm=$data['mobile_no'];
                            $message ='Dear Parents, Please pay the tution fees due for the month of ' .$month_name.'-'.$data['year'] .' of your child '.$val['full_name'].' and stay updated. Regards - Headmaster,IMSN.';

                            $result = $this->send_sms_imsn($gsm,$message);		

                            if($result==1)
                            {
                                    $data['status']=1;
                            }else{
                                    $data['status']=0;
                            }
				
				$this->unpaid_smsmodel->save_data($data);	
			}
			$this->session->set_flashdata('success',"sms has been send successfully.");
		  	  redirect('unpaid_sms');
		}
	}
	
}