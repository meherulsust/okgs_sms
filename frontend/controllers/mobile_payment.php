<?php
/*
 * Created on September 23, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Mobile_payment extends Frontend_Controller
 {
    function __construct()
    {
        $this->set_ignore_auth('mobile_payment');
		parent::__construct();
		$this->load->helper(array('html','array','form','date'));
        $this->load->model(array('mobilepaymentmodel'));
		$this->tpl->set_view(false);
        $this->tpl->set_layout(false);			
	}

  		
	function check_amount()
	{		
		$userid = mysql_real_escape_string($_GET['userid']);
		$password = mysql_real_escape_string($_GET['passwd']);
		$ref = mysql_real_escape_string($_GET['refno']);
		$gamount = mysql_real_escape_string($_GET['amount']);		
	
		$month = substr($ref,-2);
		$year = substr($ref,-6,-2);
		$ReferenceNumber = substr($ref,0,-6);	
		$get_amount = sprintf("%.2f",$gamount);

		if($userid=='imsn' AND $password=="imsn842")
		{
			
			$check_regino = $this->mobilepaymentmodel->check_valid_regino($ReferenceNumber);   // check regi no.
			if($check_regino >0)
			{				
				
				if($month >1)
				{
					$check_month = $month - 1;
					$check_previous_due_payment = $this->mobilepaymentmodel->check_due_payment($ReferenceNumber,$check_month,$year);  // check previous due payment
				}else{
					$check_previous_due_payment = 0;
				}
				$check_due_payment = $this->mobilepaymentmodel->check_due_payment($ReferenceNumber,$month,$year);      // check due payment
				
				if($check_due_payment >0 AND $check_previous_due_payment ==0)
				{
					$due_payment = $this->mobilepaymentmodel->get_due_payment($ReferenceNumber,$month,$year);    // due payment
					if($this->current_date() >= $due_payment['start_date'])
					{
						$data['payment_id'] = $due_payment['id'];
						$data['student_id'] = $due_payment['student_id'];
						$data['student_number'] = $ReferenceNumber;
						
						if($this->fine_calculate($due_payment['id']) >0)
						{
							$amount = $due_payment['ammount'] + $this->fine_calculate($due_payment['id']);
						}else{
							$amount = $due_payment['ammount'];
						}
						
						$data['amount'] = $amount;
						if($get_amount==$amount)
						{
							$insert_id = $this->mobilepaymentmodel->insert_temp_payment($data);    // insert temp payment 
							if($insert_id)
							{
								echo 'True';
							}else{
								echo 'False';
							}
						}else{
							echo 'False';
						}
						
					}else{ 
						echo 'False';  
					}
					
				}else{
					echo 'False';  
				}
				
			}else{
				echo 'False';  
			} 
			
		}else{
			echo 'False';   	
		}		
		
	}
	
	
	function payment_confirm()
	{
		
		$userid = mysql_real_escape_string($_GET['userid']);
		$password = mysql_real_escape_string($_GET['passwd']);
		$ref = mysql_real_escape_string($_GET['refno']);
		$gamount = mysql_real_escape_string($_GET['amount']);		
		$TransactionNumber = mysql_real_escape_string($_GET['txnid']);		
		$AmountCollectionDateTime = mysql_real_escape_string($_GET['txndate']);		
	
		$month = substr($ref,-2);
		$year = substr($ref,-6,-2);
		$ReferenceNumber = substr($ref,0,-6);	
		$CollectedAmount = sprintf("%.2f",$gamount);
		

		if($userid=='imsn' AND $password=="imsn842")
		{
			
			$check_transaction_status = $this->mobilepaymentmodel->check_transaction_status($ReferenceNumber,$TransactionNumber);   // check status
			
			if($check_transaction_status <=0)
			{
				$check_transaction_number = $this->mobilepaymentmodel->check_transaction_number($ReferenceNumber,$TransactionNumber);   // check duplicate transaction ID
						
				if($check_transaction_number <=0)
				{
					$payment_info = $this->mobilepaymentmodel->get_payment_info($ReferenceNumber);      // get payment info
					if(!empty($payment_info))
					{
						if($payment_info['amount']==$CollectedAmount)
						{
							$data['payment_status'] = 'Paid';
							$data['transaction_id'] = $TransactionNumber;
							$data['payment_date'] = $AmountCollectionDateTime;							
							$this->mobilepaymentmodel->update_temp_payment($payment_info['id'],$data);    // update temp payment 
							
							$this->headfineupdate($payment_info['payment_id']);  // update fine
							
							$payment_data['ammount'] = $CollectedAmount;
							$payment_data['pay_status'] = 'PAID';
							$payment_data['pay_type'] = 'SMS';
							$payment_data['payment_date'] = Date('Y-m-d H:i:s',strtotime($AmountCollectionDateTime));
							$this->mobilepaymentmodel->update_payment($payment_info['payment_id'],$payment_data);    // update payment 
							
							$insert_data['student_tuition_fee_payment_id'] = $payment_info['payment_id'];
							$insert_data['bank_transection_id'] = $TransactionNumber;
							$this->mobilepaymentmodel->insert_payment_transaction($insert_data);    // update payment 
							echo '1';
							
						}else{ 
							echo '-3';  // Invalid collected amount
						}
						
					}else{
						echo '-4';  // Unable to confirm
					}
				}else{
					echo '-2';  // Duplicate transaction number
				}
			}else{
				echo '0';  // Payment already confirmed
			} 
			
		}else{
			echo '-1';   // Invalid institute name
			
		}	
		
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
	

	function headfineupdate($pid)
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
		$fine = array();
		
		foreach($fee as $val){			
			if($current_date > $payment_info['expire_date'] AND $val->head_type=='FINE' AND $val->pay_status=='UNPAID')
			{				
				$fine = $this->tfpd->find($val->id);
				$f_amount = $f_amount + $val->ammount*$count_day;				
			}else if($current_date <= $payment_info['expire_date'] AND $val->head_type=='FINE' AND $val->pay_status=='UNPAID')
			{
				$fine = $this->tfpd->find($val->id);
			}
		}	
		
		if(!empty($fine))
		{
			if($f_amount >0)
			{
				$fine['ammount'] = $f_amount; 
				$this->tfpd->update($fine);   // update total fine
			}else{
				$fine['ammount'] = 0; 
				$this->tfpd->update($fine);   // update total fine
			}				
		}		
		
	}
	
	
 }