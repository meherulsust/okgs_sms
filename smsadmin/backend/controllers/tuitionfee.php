<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This class is for running cron job from cli
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 16, 2014
 */
class Tuitionfee extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }
	
	public function index()
	{
		$this->load->form('tuitionfeegenerateform', 'tfgform');
		$this->tpl->set_view('index');
	}
	
	public function generate(){
		$this->load->form('tuitionfeegenerateform', 'tfgform');
		if ($this->tfgform->validate()) {
			$class=$this->input->post('fee_generate_class_id');
			$year=$this->input->post('fee_generate_year');
			$month=$this->input->post('fee_generate_month');
			$start_date=$this->input->post('fee_generate_start_date');
			$expire_date=$this->input->post('fee_generate_expire_date');
			$this->load->model('tuitionfeepaymentmodel');
			$this->tuitionfeepaymentmodel->generate_student_fees($class,$year,$month,$start_date,$expire_date);
			$this->session->set_flashdata('success', "Tuition fee has been generated successfully.");
			redirect('tuitionfee/index');
		}else{
			$this->tpl->set_view('index');
		}
	}
	
	
	public function advance()
	{
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('advancefeegenerateform', 'afgform');		
	}
	
	public function advance_fee_generate(){
		$this->load->form('advancefeegenerateform', 'afgform');
		if ($this->afgform->validate()) {		
			foreach ($this->input->post('month') as $lm => $val) {
				$student_number = $this->input->post('fee_generate_student_number');
				$year = $this->input->post('fee_generate_year');
				$month = $val;
				$start_date = $this->input->post('fee_generate_start_date');
				$expire_date = $year.'-'.$month.'-'.date('d',strtotime($this->input->post('fee_generate_expire_date')));
				$this->load->model('tuitionfeepaymentmodel');
				$aa = $this->tuitionfeepaymentmodel->generate_student_advance_fees($student_number,$year,$month,$start_date,$expire_date);
			}
			$this->session->set_flashdata('success', "Tuition fee has been generated successfully.");
			redirect('tuitionfee/advance');
		}else{
			$this->tpl->set_view('advance');
		}
	}
	
	public function get_month()
	{
		$data['student_number'] = $this->input->post('student_number');
		$data['year'] = $this->input->post('year');
				
		if(!empty($data['student_number']))
		{
			$month_list = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$this->load->model('tuitionfeepaymentmodel');
			$months = $this->tuitionfeepaymentmodel->get_paymeny_month($data);
			$month_array = array();
			foreach($months as $mt){
				$month_data[$mt['month']] = $mt['month'];
				$month_array = $month_data;
			}
			$filter_months = array_diff_key($month_list, $month_array);
			
			foreach ($filter_months as $val=>$title){
				$this->html .='<input type="checkbox" id="month" name="month[]" value="' . $val . '" required/>' . $title . '</br>';
			}			
		}else{
			$this->html = '<label class="error">Student Number is required</label>';
		}
			
		$html = $this->html;
        return $this->output->set_output($html);
	}	
	
	
	public function partial_fee()
	{
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('partialfeegenerateform', 'pfgform');		
	}
	
	public function partial_fee_generate(){
		$this->load->model('tuitionfeepaymentmodel');
		$this->load->model('tuitionfeepaymentdetailsmodel');
		$this->load->form('partialfeegenerateform', 'pfgform');
		if ($this->pfgform->validate()) {	
			$student_number = $this->pfgform->get_value('student_number');
			$info = $this->tuitionfeepaymentmodel->get_student_info_for_advance_fee($student_number);
			$payment['student_id'] = $this->input->post('student_id');
			$payment['payment_class_id'] = $info['class_id'];
			$payment['payment_section_id'] = $info['section_id'];
			$payment['month'] = $this->pfgform->get_value('month');
			$payment['year'] = $this->pfgform->get_value('year');
			$payment['start_date']= $this->pfgform->get_value('start_date');
			$payment['expire_date']= $this->pfgform->get_value('expire_date');
			$payment['payment_generate_type']= 2;
			$payment['created_by'] = $this->session->userdata('user_id');
			$payment_id = $this->tuitionfeepaymentmodel->insert($payment);				
					
			$amount = $this->input->post('amount');
			$head_type = $this->input->post('head_type');
			$total = 0.00;
			foreach ($this->input->post('head') as $lm => $val){				
				$data['tuition_fee_head_id'] = $val;
				$data['student_tuition_fee_payment_id'] = $payment_id;	
				$data['ammount'] = $amount[$val];				
				$data['created_by'] = $this->session->userdata('user_id');
				$this->tuitionfeepaymentdetailsmodel->insert($data);
				if($head_type[$val] == 'FINE')
				{
					$total += 0.00;
				}else{
					$total += $amount[$val];
				}							
			}
			
			$this->tuitionfeepaymentmodel->update(array('ammount' => $total, 'id' => $payment_id));
			$this->session->set_flashdata('success', "Partial tuition fee has been generated successfully.");
			redirect('tuitionfee/partial_fee');
		}else{
			$this->tpl->set_view('partial_fee');
		}
	}
	
	public function get_head_list()
	{
		$student_number = $this->input->post('student_number');
		$data['year'] = $this->input->post('year');
		$data['month'] = $this->input->post('month');
		
		$this->load->model('tuitionfeepaymentmodel');
		$this->load->model('tuitionfeeheadmodel');
		$student_info = $this->tuitionfeepaymentmodel->get_student_info_for_advance_fee($student_number);
				
		if(!empty($student_info))
		{
			$data['student_id'] = $student_id = $student_info['student_id'];
			$advance_payment = $this->tuitionfeepaymentmodel->check_advance_duplicate_fee($data);
			
			if($advance_payment>0)
			{				
				$fee_list = $this->tuitionfeeheadmodel->get_all_head();
				$this->html = '<input type="hidden" name="student_id" value="'.$student_id.'"/>';
				$this->html .= '<table style="width:600px !important;">';
				foreach($fee_list as $val){
					$this->html .= '<tr>';
					$this->html .='<td style="height:20px;"><input type="checkbox" id="head" name="head[]" value="' . $val['id'] . '" required/>' . $val['title'] . '</td>';
					$this->html .= '<td style="height:20px;"><input style="text-align:center;" type="hidden" name="head_type['.$val['id'].']" value="'.$val['head_type'].'"/>'.$val['head_type'].'</td>';
					$this->html .= '<td style="height:20px;"><input style="width:100px;text-align:right;" type="text" name="amount['.$val['id'].']" value="'.$val['ammount'].'"/></td>';
					$this->html .= '</tr>';
				}
				$this->html .= '</table>';
			}else{
				$this->html = '<label class="error">No advance payment for this month.</label>';
			}
			
		}else{
			$this->html = '<label class="error">Student not available.</label>';
		}
			
		$html = $this->html;
        return $this->output->set_output($html);
	}
	
	public function fine_generate()
	{
		//$this->load->model('tuitionfeepaymentmodel');
		//$this->tuitionfeepaymentmodel->generate_student_fine('2014','10');
		$this->load->form('finegenerateform', 'fgform');
		if ($this->fgform->validate()) {
			$year=$this->input->post('fine_generate_year');
			$month=$this->input->post('fine_generate_month');
			$this->load->model('tuitionfeepaymentmodel');
			$this->tuitionfeepaymentmodel->generate_student_fine($year,$month);
			$this->session->set_flashdata('success', "Fine has been generated successfully.");
			redirect('tuitionfee/index');
		}else{
			$this->tpl->set_view('fine_generate');
		}
	}	
	
	
	public function delete_tuition_fee()
	{
		$this->load->helper('date');
		$this->load->form('tuitionfeedeleteform', 'tfdform');
		if ($this->tfdform->validate()) {
			$class=$this->input->post('fee_delete_class_id');
			$year=$this->input->post('fee_delete_year');
			$month=$this->input->post('fee_delete_month');	
			$date=Date('Y-m-d');	
			$this->load->model('tuitionfeepaymentmodel');
			$check_payment_status = $this->db->query("SELECT stfp.id FROM sms_student_tuition_fee_payment stfp LEFT JOIN sms_admission ad ON ad.student_id=stfp.student_id where ad.class_id='$class' AND stfp.year='$year' AND stfp.month='$month' AND pay_status='PAID'");
			if ($check_payment_status->num_rows() <= 0)
			{
				$query = $this->db->query("SELECT stfp.id FROM sms_student_tuition_fee_payment stfp LEFT JOIN sms_admission ad ON ad.student_id=stfp.student_id where ad.class_id='$class' AND stfp.year='$year' AND stfp.month='$month' AND stfp.payment_generate_type=0");
				if ($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{					
						$payment_id=$row->id;					
						$this->db->query("DELETE sms_student_tuition_fee_payment,sms_student_tuition_fee_payment_details FROM sms_student_tuition_fee_payment INNER JOIN sms_student_tuition_fee_payment_details ON sms_student_tuition_fee_payment.id=sms_student_tuition_fee_payment_details.student_tuition_fee_payment_id WHERE sms_student_tuition_fee_payment.id=$payment_id");
					}
					$this->session->set_flashdata('success', "Tuition fee has been deleted successfully.");
					redirect('tuitionfee/delete_tuition_fee'); 
				}
				else{
					$this->session->set_flashdata('error', "No data available for today or delete parameters.");
					redirect('tuitionfee/delete_tuition_fee'); 
				}
			}else{
				$this->session->set_flashdata('error', "Already paid this payment.");
				redirect('tuitionfee/delete_tuition_fee');
			}
		}else{
			$this->tpl->set_view('delete_tuition_fee');
		}
	}
	
	
	public function duplicate_fee_check($month)
	{
		$class=$this->input->post('fee_generate_class_id');
		$year=$this->input->post('fee_generate_year');
		$query = $this->db->query("SELECT stfp.id FROM sms_student_tuition_fee_payment stfp LEFT JOIN sms_admission ad ON ad.student_id=stfp.student_id where ad.class_id='$class' AND stfp.year='$year' AND stfp.month='$month' AND stfp.payment_generate_type=0");
		$count=$query->num_rows();
		if($count>0)		
		{
			$this->form_validation->set_message('duplicate_fee_check', 'You have already generated tuition fee for this month.');
			return FALSE;			
		}else{
			return TRUE;			
		}
	}
	
	public function duplicate_advance_fee_check($month)
	{
		$student_number=$this->input->post('fee_generate_student_number');
		$year=$this->input->post('fee_generate_year');
		$query = $this->db->query("SELECT stfp.id FROM sms_student_tuition_fee_payment stfp LEFT JOIN sms_student st ON st.id=stfp.student_id where st.student_number='$student_number' AND stfp.year='$year' AND stfp.month='$month' AND stfp.payment_generate_type=1");
		$count=$query->num_rows();
		if($count>0)		
		{
			$this->form_validation->set_message('duplicate_advance_fee_check', 'You have already generated tuition fee for this student on this month.');
			return FALSE;			
		}else{
			return TRUE;			
		}
	}
	
	
	public function duplicate_fine_check($month)
	{
		$year=$this->input->post('fine_generate_year');
		$this->load->model('tuitionfeepaymentmodel');
		$count=$this->tuitionfeepaymentmodel->check_duplicate_fine($year,$month);
		if($count>0)		
		{
			$this->form_validation->set_message('duplicate_fine_check', 'You have already generated fine for this month.');
			return FALSE;			
		}else{
			return TRUE;		
		}
	}
	

}