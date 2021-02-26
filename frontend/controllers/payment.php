<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Payment extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {		
		$this->load->model('studentvmodel');
		$this->load->helper('date');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$student_id = $row['id'];
		$this->tpl->assign($row);
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$fees = $this->tfp->get_student_fee($student_id);
		$fee = array();
		foreach($fees as $val){
			$data['id'] = $val->id;
			$data['student_id'] = $val->student_id;
			$data['ammount'] = number_format($val->ammount + $this->fine_calculate($val->id),2);
			$data['month'] = $val->month;
			$data['year'] = $val->year;
			$data['pay_status'] = $val->pay_status;
			$data['pay_type'] = $val->pay_type;
			$data['start_date'] = $val->start_date;
			$data['expire_date'] = $val->expire_date;
			$data['payment_generate_type'] = $val->payment_generate_type;
			$data['bank_transection_id'] = $val->bank_transection_id;	
			$fee[] = $data;			
		}
		
		$this->tpl->assign('fees',$fee);
		$current_date = $this->current_date();
		$this->tpl->assign('current_date',$current_date);
    }
	
	
	function fine_calculate($pid)
	{	
		$this->load->helper('date');
		$this->load->model('tuitionfeepaymentdetailsmodel','tfpd');
		$this->load->model('tuitionfeepaymentmodel','tfp');
		
		$current_date = $this->current_date();
		$fee = $this->tfpd->get_fees($pid);
		$payment_info = $this->tfp->find($pid);
		/*----- day count ------*/
		$datetime1 = new DateTime($payment_info['expire_date']);
		$datetime2 = new DateTime($current_date);
		$interval = $datetime1->diff($datetime2);
		$count_day = $interval->days;
		/*----- day count ------*/
		
		$f_amount =0.00;
		foreach($fee as $val){			
			if($current_date > $payment_info['expire_date'] AND $val->head_type=='FINE' AND $val->pay_status=='UNPAID')
			{				
				$f_amount = $f_amount + $val->ammount*$count_day;				
			}
		}
		
		return $f_amount; 
	}
	
	
	
	
    function details($pid)
	{
		/*---------- Unset session data ----------*/
		$sdata['payment_id']='';
		$sdata['total_amount']='';
		$sdata['fine_head_id']='';
		$this->session->unset_userdata($sdata);
		/*---------- Unset session data ----------*/
		
		$this->load->model('studentvmodel');
		$this->load->model('schoolmodel');
		$school_info = $this->schoolmodel->find(1);
		$this->load->helper('date');
		$this->load->model('tuitionfeepaymentdetailsmodel','tfpd');
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->tpl->assign($row);
		$current_date = $this->current_date();
		$fee = $this->tfpd->get_fees($pid);
		$payment_info = $this->tfp->find($pid);
		$pid = $payment_info['id'];
		$info = $this->tfp->get_student_payment($pid);
		$payment_date = date('Y-m-d',strtotime($payment_info['payment_date']));
		/*----- day count ------*/		
		$count_day = $this->count_day($payment_info['expire_date'],$current_date);
		/*----- day count ------*/
		
		$all_data=array();
		$fine_amount =0.00;
		$fine_head_id = 0;
		foreach($fee as $val){
			$data['head_type']= $val->head_type;
			$data['head_code']= $val->head_code;
			//$data['fee_generation_date'] = $val->fee_generation_date;
			//$data['expire_date'] = $val->expire_date;
			$data['title'] = $val->title;
			$data['tuition_fee_head_id'] = $val->tuition_fee_head_id;
			$data['student_id'] = $val->student_id;		
			$data['id'] = $val->id;
			
			if($current_date > $payment_info['expire_date'] AND $data['head_type']=='FINE' AND $val->pay_status=='UNPAID')
			{				
				$data['ammount'] = '('.$val->ammount.'x'.$count_day.') '.number_format($val->ammount*$count_day,2);
				$fine_amount = 	$val->ammount;	
				$fine_head_id = $val->id;
				
			}elseif($data['head_type']=='FINE' AND $val->pay_status=='PAID' AND $payment_date <= $payment_info['expire_date']){			
				$data['ammount'] = '0.00';				
			}
			elseif($data['head_type']=='FINE' AND $val->pay_status=='PAID' AND $payment_date >= $payment_info['expire_date']){			
				$data['ammount'] = $val->ammount;
						
			}
			else{
				if($data['head_type']=='FINE')
				{
					$data['ammount'] = '0.00';
					$fine_head_id = $val->id;
					$fine_amount = 	'0.00';	
				}else{
					$data['ammount'] = $val->ammount;	
				}	
			}				
			
			$all_data[] = $data;
		}
		
		$total_amount = $payment_info['ammount'] + ($fine_amount * $count_day); 
		
		/*---------- Unset session data ----------*/
		$ssdata['payment_id'] = $pid;
		$ssdata['total_amount'] = $total_amount;
		$ssdata['fine_head_id'] = $fine_head_id;
		$ssdata['fine_amount'] = $fine_amount;
		$this->session->set_userdata($ssdata);
		/*---------- Unset session data ----------*/
		
		//prevent manually id change in browser.
		if($row['id'] !=$payment_info['student_id']){
			redirect('payment');
		}
		$this->tpl->assign('payment_info',$payment_info);
		$this->tpl->assign('info',$info);
		$this->tpl->assign('tuition_fees',$all_data);
		$this->tpl->assign('school_info',$school_info);
		$data['current_date']= $this->current_date();
		$data['total_amount']= number_format($total_amount,2);
		$this->tpl->assign($data);	
    }
	
    function create()
	{
		$this->load->model('studentvmodel');
		$this->load->helper('date');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$fee = $this->tfp->get_student_fee($row['id']);
		$this->tpl->assign('tuition_fees',$fee);
		$this->tpl->assign($row);
		$data['current_date']= date(DATE_FORMAT);
		$this->tpl->assign($data);	
    }
	
	
	public function submit_payment()
	{
        $payment_id = $this->session->userdata('payment_id');
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
		$this->tpl->assign('school_info',$school_info);
        $this->load->model('tuitionfeepaymentmodel','tfp');
        $fee = $this->tfp->find($payment_id);
        $params['amount'] = $this->session->userdata('total_amount');
        $params['head'] = 'Tuition fee of '.date('F', mktime(0, 0, 0, $fee['month'], 10)).','.$fee['year'];
        $this->tpl->assign($params);        
    }
    
    public function save()
	{
        $payment_id = $this->session->userdata('payment_id');
        if($payment_id)
		{
			$this->load->model('studentvmodel');
			$student_number = $this->auth->get_user()->student_number;
			$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
			$this->load->model('tuitionfeepaymentmodel','tfp');
			$fee = $this->tfp->find($payment_id);
			
			$data['payment_id'] = $payment_id;
			$data['student_id'] = $row['id'];
			$data['student_number'] = $row['student_number'];
			$data['amount'] = $this->session->userdata('total_amount');
			$data['request_from'] = 'WEB';
			$this->load->model('paymentmodel');
			$tem_payment_id = $this->paymentmodel->insert_temp_payment($data);
			if($tem_payment_id)
			{
				$userid='RcPsc';
				$password='rCpSC0053';
				$reference_no = $tem_payment_id;
				$amount = $data['amount'];
				header('location:http://mobile.trustbanklimited.com/APIReferSite/RecPoster.aspx?uid='.$userid.'&password='.$password.'&billcode='.$reference_no.'&amount='.$amount);
				exit();
			}else{
				redirect('payment/submit_payment');
			}			
        }else{
			redirect('payment/submit_payment');
		}
    }
 
    public function success_payment()
	{
        $payment_id = $this->session->userdata('payment_id');
        if($payment_id)
		{
			$payment_id = $this->session->userdata('payment_id');
			// payment update
			$this->load->model('paymentmodel');
			$temp_payment_info = $this->paymentmodel->get_temp_payment_info($payment_id);
			
			$this->load->model('tuitionfeepaymentmodel','tfp');
			$fee = $this->tfp->find($payment_id);
			$fee['ammount'] = $temp_payment_info['amount'];
			$fee['pay_status'] = 'PAID';
			$fee['pay_type'] = 'WEB';
			//$fee['transaction_id'] = $temp_payment_info['transaction_id'];
			$fee['payment_date'] = $temp_payment_info['payment_date'];
			$this->tfp->update($fee);
			
			// insert transaction ID
			$this->load->model('studentpaymentmodel','spm');
			$data['id'] = '';
			$data['student_tuition_fee_payment_id'] = $payment_id;
			$data['bank_transection_id'] = $temp_payment_info['transaction_id'];
			$this->spm->insert($data);
			// Fine update
			if($this->session->userdata('fine_head_id')>0)
			{
				$this->load->model('tuitionfeepaymentdetailsmodel','tfpd');
				$fine = $this->tfpd->find($this->session->userdata('fine_head_id'));
				$fine['ammount'] = $this->session->userdata('fine_amount');
				$this->tfpd->update($fine);
			}
			$this->flash_message('success', "<div class='success'>Payment has been completed successfully.</div>");
			redirect('payment');
		}else{
			echo 'Session has been expired. Please contact with system authority.';
		}
    }
    
       
	private function _sendPostData($url, $post)
	{
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        $result = curl_exec($ch);
        curl_close($ch);  // Seems like good practice
        return $result;
	}
	
	
	
	
	public function download($pid)
	{
		$this->tpl->set_layout(false);	
		$this->load->library('pdf');
				
		$this->load->model('studentvmodel');
		$this->load->model('schoolmodel');
		$school_info = $this->schoolmodel->find(1);
		$this->load->helper('date');
		$this->load->model('tuitionfeepaymentdetailsmodel','tfpd');
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->tpl->assign($row);
		
		$current_date = $this->current_date();
		$fee = $this->tfpd->get_fees($pid);
		$payment_info = $this->tfp->find($pid);
		$payment_date = date('Y-m-d',strtotime($payment_info['payment_date']));
		/*----- day count ------*/		
		$count_day = $this->count_day($payment_info['expire_date'],$current_date);
		/*----- day count ------*/
		
		$all_data=array();
		$fine_amount =0.00;
		$fine_head_id = 0;
		foreach($fee as $val){
			$data['head_type']= $val->head_type;
			$data['head_code']= $val->head_code;
			//$data['fee_generation_date'] = $val->fee_generation_date;
			//$data['expire_date'] = $val->expire_date;
			$data['title'] = $val->title;
			$data['tuition_fee_head_id'] = $val->tuition_fee_head_id;
			$data['student_id'] = $val->student_id;		
			$data['id'] = $val->id;
			
			if($current_date > $payment_info['expire_date'] AND $data['head_type']=='FINE' AND $val->pay_status=='UNPAID')
			{				
				$data['ammount'] = '('.$val->ammount.'x'.$count_day.') '.number_format($val->ammount*$count_day,2);
				$fine_amount = 	$val->ammount;	
				$fine_head_id = $val->id;
				
			}elseif($data['head_type']=='FINE' AND $val->pay_status=='PAID' AND $payment_date <= $payment_info['expire_date']){			
				$data['ammount'] = '0.00';				
			}
			elseif($data['head_type']=='FINE' AND $val->pay_status=='PAID' AND $payment_date >= $payment_info['expire_date']){			
				$data['ammount'] = $val->ammount;
			}
			else{
				if($data['head_type']=='FINE')
				{
					$data['ammount'] = '0.00';	
				}else{
					$data['ammount'] = $val->ammount;	
				}				
			}				
			
			$all_data[] = $data;
		}
		
		$total_amount = $payment_info['ammount'] + ($fine_amount * $count_day); 
				
		//prevent manually id change in browser.
		$payment = $this->tfp->find($pid);
		$info = $this->tfp->get_student_payment($pid);
		if($row['id'] !=$payment['student_id']){
			redirect('payment');
		}
		
		$this->tpl->assign('payment_id',$pid);
		$this->tpl->assign('tuition_fees',$all_data);
		$this->tpl->assign('school_info',$school_info);
		$data['current_date']= $this->current_date();
		$data['total_amount']= number_format($total_amount,2);
		$this->tpl->assign($data);


		$html = '<style type="text/css">
		.receipt_head,.receipt_body{
			border-collapse:collapse;
		}

		.receipt_head tr td{
			border:1px solid #ddd;
		}
		.receipt_head tr td{
			font-size:12px;
			padding:2px 4px;	
		}
		.receipt_body tr td{
			font-size:12px;
			border:1px solid #ddd;
			padding:2px 6px;
		}
		</style>';	
		
		$html .='<h6 align="center"><img src="'.base_url().'smsadmin/uploads/logo/'.$school_info['logo_file'].'" style="border:none;width:80px;" /></h6>';
		$html .='<h4 align="center">'.strtoupper($school_info['name']).'</h4>
			<h6 align="center">'.strtoupper($school_info['address1']).'<br>'.strtoupper($school_info['address2']).'</h6>';

		$html .='<table width="80%" align="center" class="receipt_head">			
					<tr>
						<td width="25%">Student Name</td>
						<td width="25%"> : '.$row["first_name"].' '.$row["last_name"].'</td>
						<td align="right">Date </td>
						<td width="25%"> : '.$this->current_date().'</td>	
					</tr>
					<tr>
						<td>Student Number </td>
						<td>: '.$row["student_number"].'</td>
						<td align="right">Class Roll </td>
						<td width="25%"> : '.$row["class_roll"].'</td>
					</tr>
					<tr>
						<td width="25%">Class</td>
						<td width="25%"> : '.$row["class"].'</td>
						<td width="25%" align="right">Form </td>
						<td width="25%"> : '.$row["section"].'</td>
					</tr>
					<tr>
						<td width="25%">Month</td>
						<td width="25%"> : '.date("F", mktime(0, 0, 0, $payment["month"], 10)).'</td>
						<td width="25%" align="right">Payment Date</td>
						<td width="25%"> : '.$payment["payment_date"].'</td>
					</tr>
					<tr>
						<td width="25%">Payment Status</td>
						<td width="25%"> : '.$payment["pay_status"].'</td>
						<td width="25%" align="right">Transaction ID</td>
						<td width="25%"> : '.$info["bank_transection_id"].'</td>
						
					</tr>
				</table><br>';	
		$html .='<table width="80%" align="center" class="receipt_body">		
				<tr>
					<td width="5%" align="center"><b>SL.</b></td>
					<td width="60%" align="center"><b>Name of Head</b></td>
					<td width="25%" align="center"><b>Amount</b></td>
				</tr>';
		if(!empty($all_data)):
		$i=1;
		foreach($all_data as $val):		
		$html .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.$val['title'].'</td>
					<td align="right">'.$val['ammount'].'</td>
				</tr>';
			$i++;
		endforeach;	
		$html .='<tr>
					<td colspan="2" align="right"><b>Total Amount :</b></td>
					<td align="right"><b>'.$data['total_amount'].'</b></td>
				</tr>';
		endif;		
		$html .='</table>';		

		$full_html=	$html; 
		//$title['page_title'] = 'Invoice';
		//$html = $this->load->view('purchases/invoice',$title,true); // render the view into HTML
		$pdf = $this->pdf->load();
		$pdf->WriteHTML($full_html); // write the HTML into the PDF
		$pdf->Output('Invoice_'.$data['current_date'].'.pdf','D');
		exit;
		
		
	}
	
	
	function count_day($date1,$date2)
	{
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$interval = $datetime1->diff($datetime2);
		$count_day = $interval->days;
		return $count_day;
	}
	
	
	
 }