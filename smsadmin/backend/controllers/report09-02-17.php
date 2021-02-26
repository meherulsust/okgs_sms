<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This class contains all reports.
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 21, 2014
 */
class Report extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        
    }

    function student_payment() {
        $this->tpl->set_js('select-chain');
        $this->load->filter('studentpaymentfilter', 'stdpayfilter');
        $this->init_student_payment_grid();
    }

    protected function init_student_payment_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Student Tuition Fee List');
        $grid_columns = array('id' => array('visible' => false), 'student_number' => 'Student Number', 'full_name' => 'Student Name', 'class' => 'Class', 'section' => 'Form', 'class_roll' => 'Class Roll',
            'student_type' => 'Student Type','month_name' => 'Month', 'year' => 'Year', 'pay_status' => 'Status', 'ammount' => 'Amount','pay_date' => 'Payment Date', 'expire_date' => array('title' => 'Expire Date', 'date' => true));
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'config' => array('title' => 'Advanced Payment', 'action' => 'make_advp', 'controller' => '', 'tips' => 'Make Advanced Payment'),
			'view' => array('title' => 'View', 'action' => 'paydetails', 'controller' => '', 'tips' => 'View record details'),
			'edit' => array('title' => 'edit', 'action' => 'edit_payment_status', 'controller' => '', 'tips' => 'Edit payment status'),
			'del' => array('title' => 'del', 'action' => 'delete_payment', 'controller' => '', 'tips' => 'Delete Payment')
			
        );
        $this->grid_board->set_filter($this->stdpayfilter);
        $this->grid_board->set_action($actions);
        $params = array('count_method' => 'student_payment_report_count', 'model' => 'tuitionfeepaymentmodel', 'method' => 'student_payment_report');
        $this->grid_board->render($params);
    }

    function student_payment_filter() {
        $this->load->filter('studentpaymentfilter', 'stdpayfilter');
        $this->stdpayfilter->execute();
        redirect('report/student_payment');
    }
	
	public function make_advp($id = ''){
			$this->load->model('tuitionfeepaymentmodel', 'tfpm');
			$info = $this->tfpm->get_payment_details($id);
			$this->load->form('make_advpform', null,$info);
			$this->tpl->assign('id',$id);
			if($this->make_advpform->validate()){
				$data['payment_generate_type'] = $this->make_advpform->get_value('payment_generate_type');
				$data['id'] = $id;
				$advp = $this->tfpm->advp_data($data,$id);
				$this->session->set_flashdata('success', "Payment Generate successfully.");
				redirect('report/student_payment');
			}
	
		
	}

    public function paydetails($id) {
        $this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
        $fees = $this->tfpdm->get_fees($id);
        $this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $std_info = $this->tfpm->get_student_min_info($id);
        $this->tpl->assign('std_info', $std_info);
		$this->tpl->assign('fees', $fees);
		$info = $this->tfpm->get_payment_details($id);
		$this->tpl->assign('payment_status',$info['pay_status']);
    }
	
	public function edit_payment_status($id)
	{
		$this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $info = $this->tfpm->get_payment_details($id);
		if($info['pay_status']=='UNPAID')
		{
			$this->tpl->assign('id',$id);
			$this->load->model('tuitionfeepaymentmodel', 'tfpm');
			$data = $this->tfpm->get_payment_details($id);
			$this->load->form('editpaymentstatusform', null, $data);
			
			if($this->editpaymentstatusform->validate()) {
						
				$this->editpaymentstatusform->save();        
				$this->session->set_flashdata('success', "Payment has been updated successfully.");
				redirect('report/student_payment');
				
			}else{
				$this->tpl->set_view('edit_payment_status');
			}
		}else{
			$this->session->set_flashdata('error', "This payment already paid.");	
			redirect('report/student_payment');				
		}		
	}
	
	
	public function edit_payment($id)
	{
		$this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
        $fees_details = $this->tfpdm->get_fee_details($id);
		$this->tpl->assign('fees',$fees_details);
		$data['amount']=$fees_details['ammount'];
		$data['total_amount']=$fees_details['total_amount'];
		$payment_id = $fees_details['student_tuition_fee_payment_id'];
		$this->load->form('editpaymentform', null, $fees_details);
		
		if($this->editpaymentform->validate()) {
            
			$change_amount = $this->input->post('payment_ammount');
			$find_change_amount = $change_amount - $data['amount'];
			$final_amount['ammount'] = $data['total_amount'] + $find_change_amount;
			
			$this->editpaymentform->save();
			if($fees_details['head_type']!='FINE'){        
			$this->tfpdm->update_total_payment($payment_id,$final_amount);	
			}
			$this->session->set_flashdata('success', "Payment has been updated successfully.");
            redirect('report/paydetails/'.$payment_id);
			
        }else{
			$this->tpl->set_view('edit_payment');
		}
	}	
	
	protected function process_form($form,$data) {
		$this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
		
		if($form->validate()) {
            
			$payment_id = $this->input->post('payment_student_tuition_fee_payment_id');
			$change_amount = $this->input->post('payment_ammount');
			$total_amount = $this->input->post('payment_total_amount');
			$amount = $data['amount'];
			
			$find_change_amount = $change_amount - $amount;
			$final_amount['ammount'] = $total_amount;
			
			$form->save();        
			$this->tfpdm->update_total_payment($payment_id,$final_amount);	
			$this->session->set_flashdata('success', "Payment has been updated successfully.");
            redirect('report/paydetails/'.$payment_id);
        }
    }
	
	public function delete_payment($id)
	{
		$this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $info = $this->tfpm->get_payment_details($id);
		if($info['pay_status']=='UNPAID')
		{
			$this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
			$fees = $this->tfpdm->get_fees($id);		
			foreach($fees as $val){
				$this->tfpdm->delete($val->id);
			}
			$this->tfpm->delete($id);
			$this->session->set_flashdata('success', "Payment has been deleted successfully.");
		}else{
			$this->session->set_flashdata('error', "This payment already paid.");			
		}	
		redirect('report/student_payment');		
	}
	
    function view($id) {
        $this->load->model('absentmodel');
        $info = $this->absentmodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $labels = array('student_name' => 'Student Name', 'absent_date' => 'Absent Date', 'class' => 'Class', 'section' => 'Form',
            'class_roll' => 'Class Roll', 'remarks' => 'Remarks', 'created_by' => 'Created By', 'created_at' => 'Created at');

        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view', true);
    }

    function report_generate() {
        $this->load->form('reportgenerateform', 'rgform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
    }

    function download() {
        $this->tpl->set_layout('ajax_layout');

        /* ----------------- get search value ------------- */
        $sdata['class_id'] = $this->input->post('report_class_id');
        $sdata['section_id'] = $this->input->post('report_section_id');
        $sdata['pay_status'] = $this->input->post('report_pay_status');
        $sdata['year'] = $this->input->post('report_year');
        $sdata['month'] = $this->input->post('report_month');
        $sdata['day_from'] = $this->input->post('report_day_from');
        $sdata['day_to'] = $this->input->post('report_day_to');
		$sdata['student_number'] = $this->input->post('report_student_number');
		$sdata['payment_mode'] = '';
        /* ----------------- End search value ------------- */

        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $this->tpl->assign('school_info', $school_info);

        $this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
        $fees = $this->tfpdm->get_all_fees();
        //$this->tpl->assign('fees',$fees);
        $this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $std_info = $this->tfpm->get_all_student_min_info($sdata);


        $report_list = array();
        $head_list = array();
        $head1 = array();
	
        foreach ($std_info as $std) {
            $fees = $this->tfpdm->get_fees($std->id);
            foreach ($fees as $fee) {
                $f_data['head_id'] = $fee->tuition_fee_head_id;
                $f_data['title'] = $fee->title;
				if($fee->head_type=='FINE')
				{
					if($std->pay_status=='PAID')
					{
						$f_data['amount'] = $fee->ammount;
					}else{
						$f_data['amount'] = '0.00';
					}
				}else{
					$f_data['amount'] = $fee->ammount;
				}
                
                $head_list[] = $f_data;
            }

            $data['id'] = $std->id;
            $data['student_number'] = $std->student_number;
            $data['student_name'] = $std->first_name . ' ' . $std->last_name;
			$data['class'] = $std->class;
			$data['section'] = $std->section;
            $data['class_roll'] = $std->class_roll;
			$data['house_name'] = $std->house_name;
			$data['pay_status'] = $std->pay_status;
			$data['payment_date'] = $std->payment_date;
			$data['month'] = date("F", mktime(0, 0, 0, $std->month, 10));
			$data['payment_generate_type'] = $std->payment_generate_type;
            $data['head'] = $head_list;
            $data['t_amount'] = $std->ammount;
            $report_list[] = $data;

            $head1 = array_merge($head1, $head_list);
            $head_list = array();
        }

        $head_info = $this->super_unique($head1, 'head_id');

        /* echo '<pre>';
          print_r($report_list);
          exit(); */

        $this->tpl->assign('head_info', $head_info);
        $this->tpl->assign('report_list', $report_list);
        $count = $this->tfpm->count_all_student_min_info($sdata);
        $this->tpl->assign('total_student', $count);

        /* --------- generate search head ----------- */

        $this->load->model('classmodel');
        $class_info = $this->classmodel->find($sdata['class_id']);
        $this->tpl->assign('class_info', $class_info);
        $this->load->model('sectionmodel');
        $section_info = $this->sectionmodel->find($sdata['section_id']);
        $this->tpl->assign('section_info', $section_info);

        if ($sdata['class_id'] == '0' OR $sdata['class_id'] == '') {
            $class = 'All';
        } else {
            $class = $class_info['title'];
        }
		if ($sdata['section_id'] == '0' OR $sdata['section_id'] == '') {
            $section = '';
        } else {
            $section = ', Form : ' . $section_info['title'];
        }
        if ($sdata['pay_status'] == '0') {
            $pay_status = ', Payment Status : All';
        } else {
            $pay_status = ', Payment Status : ' . $sdata['pay_status'];
        }
		if ($sdata['year'] == '0') {
            $year = ', Year : All';
        } else {
            $year = ', Year : ' . $sdata['year'];
        }
		if ($sdata['month'] == '0') {
            $month = ', Month : All';
        } else {
            $month = ', Month : ' . date("F", mktime(0, 0, 0, $sdata['month'], 10));
        }
		
		if ($sdata['student_number'] == '') {
            $student_number = '';
        } else {
            $student_number = ', Student Number : ' . $sdata['student_number'];
        }
		
        if ($sdata['day_from'] != '' AND $sdata['day_to'] == '') {
            $date = $year . $month . ', Day :' . $sdata['day_from'];
        } else if ($sdata['day_from'] == '' AND $sdata['day_to'] != '') {
            $date = $year . $month . ', Day :' . $sdata['day_to'];
        } else if ($sdata['day_from'] != '' AND $sdata['day_to'] != '') {
            $date = $year . $month . ', Day :' . $sdata['day_from'] . ' to ' . $sdata['day_to'];
        } else {
            $date = $year .  $month . ', Day : All';
        }

        $report_title = 'Report for Class : ' . $class . $section . $pay_status . $date . $student_number;
        $this->tpl->assign('report_title', $report_title);
        $report_file_name = 'Financail_report_class_' . $class . '_' . date('y-m-d') . '.xls';
        $this->tpl->assign('report_file_name', $report_file_name);
        /* --------- end generate search head ----------- */

        if ($count <= 0) {
            $this->session->set_flashdata('info', "No data available.");
            redirect('report/report_generate');
        }
    }
	
	
	/*--------------------  start monthly report ---------------------*/
	
	function monthly_report() {        
        
		$this->load->form('monthlyreportform', 'mrform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'monthlyreportform'));
	}

	function monthly_report_download() {
        $this->tpl->set_layout('ajax_layout');

        /* ----------------- get search value ------------- */
        $sdata['class_id'] = '';
        $sdata['section_id'] = '';
        $sdata['pay_status'] = $this->input->post('report_pay_status');
        $sdata['year'] = $this->input->post('report_year');
        $sdata['month'] = $this->input->post('report_month');
		$sdata['day_from'] = $this->input->post('report_day_from');
        $sdata['day_to'] = $this->input->post('report_day_to');
        $sdata['student_number'] = '';
		$sdata['payment_mode'] = '';
        /* ----------------- End search value ------------- */

        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $this->tpl->assign('school_info', $school_info);
		$this->load->model('classmodel');
		$class_list = $this->classmodel->get_class_list();
		$this->tpl->assign('class_list', $class_list);
        $this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
        $fees = $this->tfpdm->get_all_fees();
        //$this->tpl->assign('fees',$fees);
        $this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $std_info = $this->tfpm->get_all_student_min_info($sdata);


        $report_list = array();
        $head_list = array();
        $head1 = array();
	
        foreach ($std_info as $std) {
            $fees = $this->tfpdm->get_fees($std->id);
            foreach ($fees as $fee) {
                $f_data['head_id'] = $fee->tuition_fee_head_id;
                $f_data['title'] = $fee->title;
				if($fee->head_type=='FINE')
				{
					if($std->pay_status=='PAID')
					{
						$f_data['amount'] = $fee->ammount;
					}else{
						$f_data['amount'] = '0.00';
					}
				}else{
					$f_data['amount'] = $fee->ammount;
				}
                
                $head_list[] = $f_data;
            }

            $data['id'] = $std->id;
            $data['student_number'] = $std->student_number;
            $data['student_name'] = $std->first_name . ' ' . $std->last_name;
			$data['class_id'] = $std->class_id;
			$data['class'] = $std->class;
			$data['section'] = $std->section;
            $data['class_roll'] = $std->class_roll;
			$data['house_name'] = $std->house_name;
			$data['pay_status'] = $std->pay_status;
			$data['payment_date'] = $std->payment_date;
			$data['month'] = date("F", mktime(0, 0, 0, $std->month, 10));
			$data['payment_generate_type'] = $std->payment_generate_type;
            $data['head'] = $head_list;
            $data['t_amount'] = $std->ammount;
            $report_list[] = $data;

            $head1 = array_merge($head1, $head_list);
            $head_list = array();
        }

        $head_info = $this->super_unique($head1, 'head_id');

        /* echo '<pre>';
          print_r($report_list);
          exit(); */

        $this->tpl->assign('head_info', $head_info);
        $this->tpl->assign('report_list', $report_list);
        $count = $this->tfpm->count_all_student_min_info($sdata);
        $this->tpl->assign('total_student', $count);

        /* --------- generate search head ----------- */

        $this->load->model('classmodel');
        $class_info = $this->classmodel->find($sdata['class_id']);
        $this->tpl->assign('class_info', $class_info);
        $this->load->model('sectionmodel');
        $section_info = $this->sectionmodel->find($sdata['section_id']);
        $this->tpl->assign('section_info', $section_info);

        if ($sdata['pay_status'] == '0') {
            $pay_status = 'Payment Status : All';
        } else {
            $pay_status = 'Payment Status : ' . $sdata['pay_status'];
        }
		if ($sdata['year'] == '0') {
            $year = ', Year : All';
        } else {
            $year = ', Year : ' . $sdata['year'];
        }
		if ($sdata['month'] == '0') {
            $month = ', Month : All';
        } else {
            $month = ', Month : ' . date("F", mktime(0, 0, 0, $sdata['month'], 10));
        }
		 
		if ($sdata['day_from'] != '' AND $sdata['day_to'] == '') {
            $date = $year . $month . ', Day :' . $sdata['day_from'];
        } else if ($sdata['day_from'] == '' AND $sdata['day_to'] != '') {
            $date = $year . $month . ', Day :' . $sdata['day_to'];
        } else if ($sdata['day_from'] != '' AND $sdata['day_to'] != '') {
            $date = $year . $month . ', Day :' . $sdata['day_from'] . ' to ' . $sdata['day_to'];
        } else {
            $date = $year .  $month . ', Day : All';
        }	
        
        $report_title = 'Report for : ' . $pay_status . $date;
        $this->tpl->assign('report_title', $report_title);
        $report_file_name = 'Financail_report_for_' . date('y-m-d') . '.xls';
        $this->tpl->assign('report_file_name', $report_file_name);
        /* --------- end generate search head ----------- */

        if ($count <= 0) {
            $this->session->set_flashdata('info', "No data available.");
            redirect('report/monthly_report');
        }
    }
	
	/*--------------------  End monthly report ---------------------*/
	
	
	/*--------------------  start fund-wise report ---------------------*/
	
	function fundwise_report() {        
        
	$this->load->form('fundwisereportform', 'frform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'fundwisereportform'));
    }

	function fundwise_report_download() {
        $this->tpl->set_layout('ajax_layout');

        /* ----------------- get search value ------------- */
        $sdata['class_id'] = '';
        $sdata['section_id'] = '';
        $sdata['pay_status'] = $this->input->post('report_pay_status');
        $sdata['year'] = $this->input->post('report_year');
        $sdata['month'] = '0';
        $sdata['day_from'] = $this->input->post('report_day_from');
        $sdata['day_to'] = $this->input->post('report_day_to');
		$sdata['student_number'] = '';
		$sdata['payment_mode'] = $this->input->post('report_payment_mode');
        
		/* ----------------- End search value ------------- */

        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $this->tpl->assign('school_info', $school_info);
		$this->load->model('classmodel');
		$class_list = $this->classmodel->get_class_list();
		$this->tpl->assign('class_list', $class_list);
		$this->load->model('fundmodel');
		$fund_list = $this->fundmodel->get_fund_list();
		$this->tpl->assign('fund_list', $fund_list);
        $this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdm');
        $fees = $this->tfpdm->get_all_fees();
        //$this->tpl->assign('fees',$fees);
        $this->load->model('tuitionfeepaymentmodel', 'tfpm');
        $std_info = $this->tfpm->get_all_student_min_info($sdata);

 
        $report_list = array();
        $head_list = array();
        $head1 = array();
	
        foreach ($std_info as $std) {
            $fees = $this->tfpdm->get_fees($std->id);
            foreach ($fees as $fee) {
                $f_data['fund_id'] = $fee->fund_id;
				$f_data['head_id'] = $fee->tuition_fee_head_id;
                $f_data['title'] = $fee->title;
				if($fee->head_type=='FINE')
				{
					if($std->pay_status=='PAID')
					{
						$f_data['amount'] = $fee->ammount;
					}else{
						$f_data['amount'] = '0.00';
					}
				}else{
					$f_data['amount'] = $fee->ammount;
				}
                
                $head_list[] = $f_data;
            }

            $data['id'] = $std->id;
            $data['student_number'] = $std->student_number;
            $data['student_name'] = $std->first_name . ' ' . $std->last_name;
			$data['class_id'] = $std->class_id;
			$data['class'] = $std->class;
			$data['section'] = $std->section;
            $data['class_roll'] = $std->class_roll;
			$data['house_name'] = $std->house_name;
			$data['pay_status'] = $std->pay_status;
			$data['payment_date'] = $std->payment_date;
            $data['head'] = $head_list;
            $data['t_amount'] = $std->ammount;
            $report_list[] = $data;

            $head1 = array_merge($head1, $head_list);
            $head_list = array();
        }

        $head_info = $this->super_unique($head1, 'head_id');

       

        $this->tpl->assign('head_info', $head_info);
        $this->tpl->assign('report_list', $report_list);
        $count = $this->tfpm->count_all_student_min_info($sdata);
        $this->tpl->assign('total_student', $count);

        /* --------- generate search head ----------- */

        $this->load->model('classmodel');
        $class_info = $this->classmodel->find($sdata['class_id']);
        $this->tpl->assign('class_info', $class_info);
        $this->load->model('sectionmodel');
        $section_info = $this->sectionmodel->find($sdata['section_id']);
        $this->tpl->assign('section_info', $section_info);

        if ($sdata['pay_status'] == '0') {
            $pay_status = 'Payment Status : All';
        } else {
            $pay_status = 'Payment Status : ' . $sdata['pay_status'];
        }
		if ($sdata['year'] == '0') {
            $year = ', Year : All';
        } else {
            $year = ', Year : ' . $sdata['year'];
        }
		if ($this->input->post('report_month') == '0') {
            $month = ', Month : All';
        } else {
            $month = ', Month : ' . date("F", mktime(0, 0, 0, $this->input->post('report_month'), 10));
        }
		      
        $date = $year .  $month;
		$this->tpl->assign('year', $this->input->post('report_year'));
		$this->tpl->assign('month', $this->input->post('report_month'));
		
        $report_title = 'Report for : ' . $pay_status . $date;
        $this->tpl->assign('report_title', $report_title);
        $report_file_name = 'Financail_report_for_' . date('y-m-d') . '.xls';
        $this->tpl->assign('report_file_name', $report_file_name);
        /* --------- end generate search head ----------- */
		
        if ($count <= 0) {
            $this->session->set_flashdata('info', "No data available.");
            redirect('report/fundwise_report');
        }
    }
	
	/*--------------------  End monthly report ---------------------*/
	
	
	
    function super_unique($array, $key) {
        $temp_array = array();
        foreach ($array as &$v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = & $v;
        }
        $array = array_values($temp_array);
        return $array;
    }

		
	/*--------------------  integrate bank report ---------------------*/
	
	public function upload_sms_report()
	{
		$this->load->form('smsreportform','srform');
	}
	
	
	public function update_report()
	{
		$this->load->helper('date');
		
		$ext = end(explode(".", $_FILES['smsreport_csv_file']['name']));		
		$config['upload_path'] = $this->config->item('upload_dir') . '/sms_report/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '4000';
		$config['file_name']=$file_name= 'report_'.date('YmdHis').'.'.$ext;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('smsreport_csv_file')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('report/upload_sms_report'); 
		} else {
			
			$this->load->library('csv_reader');    // csv reader
			$filePath = $this->config->item('upload_dir') . '/sms_report/'.$file_name;
			$data = array("TransactionDate","TxCode","SenderAccountNo","SenderName","Amount","ReferanceNo","StudentShortName","NotifyingMobileNo");
			$parse_data = $this->csv_reader->parse_file($filePath,$data);  // parse csv file
			
			foreach($parse_data as $val=>$field){                
				
				$originalDate = (string)str_replace('/','-',$field['TransactionDate']); 
				$date = date("Y-m-d", strtotime($originalDate));
				$year = date("Y", strtotime($originalDate));   
				$month = date("m", strtotime($originalDate));
				
				$this->load->model('tuitionfeepaymentmodel','tfp');
				$update_data['pay_status'] = 'PAID';
				$update_data['pay_type'] = 'SMS';
				$update_data['updated_at'] = $date;
				$update_data1['bank_transection_id'] = $field['TxCode'];
				
				$param['student_id'] = $field['ReferanceNo'];
				$param['year'] = $year;
				$param['month'] = $month;
				
				$get_data=$this->tfp->get_student_tuition_fee_payment_id($param);	
				$this->tfp->update_tuition_fee_payment($get_data['id'],$update_data);
				$this->tfp->update_transaction_id($get_data['id'],$update_data1);
			}
			
			$this->session->set_flashdata('success', 'SMS payment has been updated successfully.');
			redirect('report/upload_sms_report'); 
		}
		
	}	
	
	
}