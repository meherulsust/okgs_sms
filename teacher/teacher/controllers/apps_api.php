<?php
/*
 * Created on December 07, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Apps_api extends Frontend_Controller
 {
 	function __construct()
 	{
 		$this->set_ignore_auth('apps_api');
		parent::__construct();	
		$this->load->helper(array('html','array','form','date'));
        $this->load->model(array('apimodel','studentvmodel'));
		$this->tpl->set_view(false);
        $this->tpl->set_layout(false);		
 	}
	
		
 	/*--------------- check login ------------------*/
	function check_login()
 	{ 		
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<username>2014001066</username>
			<password>123456</password>			
		</parameters>'; */
		$xml_data=$_POST['xml_data'];
		$read_xml = simplexml_load_string($xml_data); 
		$data['student_number']=trim($read_xml->username);
		$data['passwd']=trim($read_xml->password);
		
		$user = $this->apimodel->check_user($data);
		if(!empty($user))
		{
			$user_id=$user['id'];
			$username=$user['student_number'];
			$status='success';
			$message='Login Successful.';
		}else{
			$user_id='';
			$username='';
			$status='failed';
			$message='Username or password did not match.';
		}
		
		$xml_response='<parameters>
				<status>'.$status.'</status>
				<message>'.$message.'</message>
				<user_id>'.$user_id.'</user_id>
				<username>'.$username.'</username>
			</parameters>';		
		echo $xml_response;
		
 	}	
	/*--------------- End check login ------------------*/
	
	
	/*--------------- user profile info ------------------*/
	function get_user_info()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>
		</parameters>'; */
		$xml_data=$_POST['xml_data'];		
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		$user_info = $this->studentvmodel->find_row(array('id'=>$user_id));
		$xml_response='<parameters>
				<name>'.$user_info['first_name'].' '.$user_info['last_name'].'</name>
				<father_name>'.$user_info['father_name'].'</father_name>
				<mother_name>'.$user_info['mother_name'].'</mother_name>
				<version>'.$user_info['version'].'</version>
				<class>'.$user_info['class'].'</class>
				<form>'.$user_info['section'].'</form>
				<class_roll>'.$user_info['class_roll'].'</class_roll>
				<gender>'.ucfirst($user_info['gender']).'</gender>
				<mobile_no>'.$user_info['mobile'].'</mobile_no>
				<dob>'.$user_info['dob'].'</dob>
				<image>'.base_url().'smsadmin/uploads/std_photo/'.$user_info['file_name'].'</image>	
			</parameters>';		
		echo $xml_response;
	}
	/*--------------- end user profile info ------------------*/
	
	
	/*--------------- Get general notice ------------------*/
	function get_general_notice()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>
		</parameters>'; */
		$xml_data=$_POST['xml_data'];		
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		$user_info = $this->studentvmodel->find_row(array('id'=>$user_id));
		
		$data['version_id'] = $user_info['version_id'];
		$data['class_id'] = $user_info['class_id'];
		$data['section_id'] = $user_info['section_id'];
		$data['house_id'] = '';
		$data['facility_id'] = '';
		$g_notice = $this->studentvmodel->get_general_notice($data);
		
		if(!empty($g_notice))
		{
			$xml_response='<parameters>';
			foreach($g_notice as $val){		
			$xml_response .='<notice>
						<notice_title>'.$val['notice_title'].'</notice_title>
						<description>'.$val['full_notice'].'</description>						
					</notice>';
			}		
			$xml_response .='</parameters>';		
			echo $xml_response;
			
		}else{
			$xml_response='<parameters></parameters>';		
			echo $xml_response;
		}
	}
	/*--------------- End general notice ------------------*/
	
	
	/*--------------- Get personal notice ------------------*/
	function get_personal_notice()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>
		</parameters>'; */
		$xml_data=$_POST['xml_data'];		
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		$user_info = $this->studentvmodel->find_row(array('id'=>$user_id));
		
		
		$p_notice = $this->studentvmodel->get_personal_notice($user_info['student_number']);
		
		if(!empty($p_notice))
		{
			$xml_response='<parameters>';
			foreach($p_notice as $val){		
			$xml_response .='<notice>
						<notice_title>'.$val['notice_title'].'</notice_title>
						<description>'.$val['full_notice'].'</description>						
					</notice>';
			}		
			$xml_response .='</parameters>';		
			echo $xml_response;
			
		}else{
			$xml_response='<parameters></parameters>';		
			echo $xml_response;
		}
	}
	/*--------------- End personal notice ------------------*/
	
	
	
	/*--------------- Get payment list ------------------*/
	function get_payment_list()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>
		</parameters>'; */
		$xml_data=$_POST['xml_data'];		
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$fees = $this->tfp->get_student_fee($user_id);
		
		if(!empty($fees))
		{
			$xml_response='<parameters>';
			foreach($fees as $val){	
			$xml_response .='<payment>
						<payment_id>'.$val->id.'</payment_id>
						<amount>'.number_format($val->ammount + $this->fine_calculate($val->id),2).'</amount>
						<month>'.$val->month.'</month>
						<year>'.$val->year.'</year>
						<pay_status>'.$val->pay_status.'</pay_status>
						<pay_type>'.$val->pay_type.'</pay_type>
						<expire_date>'.$val->expire_date.'</expire_date>
						<transection_id>'.$val->bank_transection_id.'</transection_id>											
					</payment>';
			}		
			$xml_response .='</parameters>';		
			echo $xml_response;
			
		}else{
			$xml_response='<parameters></parameters>';		
			echo $xml_response;
		}
	}
	
	function get_payment_details()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>
			<payment_id>55</payment_id>
		</parameters>'; */
		$xml_data=$_POST['xml_data'];		
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		$payment_id = trim($read_xml->payment_id);
		
		$this->load->model('tuitionfeepaymentdetailsmodel','tfpd');
		$this->load->model('tuitionfeepaymentmodel','tfp');
		$current_date = $this->current_date();
		$fee = $this->tfpd->get_fees($payment_id);
		$payment_info = $this->tfp->find($payment_id);
		$payment_date = date('Y-m-d',strtotime($payment_info['payment_date']));
		/*----- day count ------*/		
		$count_day = $this->count_day($payment_info['expire_date'],$current_date);
		/*----- day count ------*/
		
		$all_data=array();
		$fine_amount =0.00;
		$fine_head_id = 0;
		
		
		$xml_response='<parameters>';
		foreach($fee as $val){
			$xml_response .='<payment>
				<head_title>'.$val->title.'</head_title>';
				$data['head_type']= $val->head_type;
				$data['head_code']= $val->head_code;
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
					$count_days = $this->count_day($payment_info['expire_date'],$payment_date);
					$data['ammount'] = '('.$val->ammount.'x'.$count_days.') '.number_format($val->ammount*$count_days,2);
							
				}
				else{
					if($data['head_type']=='FINE')
					{
						$data['ammount'] = '0.00';	
					}else{
						$data['ammount'] = $val->ammount;	
					}	
				}				
		
			$xml_response .='<amount>'.$data['ammount'].'</amount>
						</payment>';
		}		
		$total_amount = $payment_info['ammount'] + ($fine_amount * $count_day);
		$xml_response .='<payment>';
		$xml_response .='<head_title>Total Amount</head_title>';
		$xml_response .='<amount>'.number_format($total_amount,2).'</amount>';
		$xml_response .='</payment>';
		$xml_response .='</parameters>';		
		echo $xml_response;		
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
	
	
	function count_day($date1,$date2)
	{
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$interval = $datetime1->diff($datetime2);
		$count_day = $interval->days;
		return $count_day;
	}
	
	/*--------------- End payment list ------------------*/
	
	
	
	
	/*--------------- Get book list ------------------*/
	function get_book_list()
	{
		/* $xml_data = '<?xml version="1.0" encoding="utf-8"?>
		<parameters>
			<user_id>1066</user_id>	
		</parameters>'; */
		$xml_data=$_POST['xml_data'];	
		$read_xml = simplexml_load_string($xml_data); 
		$user_id = trim($read_xml->user_id);
		$user_info = $this->studentvmodel->find_row(array('id'=>$user_id));
		$book_list = $this->studentvmodel->get_book_list($user_info['class_id']);
		
		if(!empty($book_list))
		{
			$xml_response='<parameters>';
			foreach($book_list as $val){		
			$xml_response .='<book>
								<book_title>'.$val['title'].'</book_title>
								<writer_name>'.$val['writer_name'].'</writer_name>						
							</book>';
			}		
			$xml_response .='</parameters>';		
			echo $xml_response;
			
		}else{
			$xml_response='<parameters></parameters>';		
			echo $xml_response;
		}
	}
	/* --------------- End book list ------------------ */
	
	
		
 }

?>