<?php
/*
 * Created on September 23, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Sms extends Frontend_Controller
 {
    function __construct()
    {
        $this->set_ignore_auth('sms');
		parent::__construct();
		$this->load->helper(array('html','array','form','date'));
        $this->load->model(array('smsmodel'));
		$this->tpl->set_view(false);
        $this->tpl->set_layout(false);			
	}

  		
	function index()
	{
		$unpaidinfo = $this->smsmodel->get_unpaidinfo();
		echo '<pre>';
		print_r($unpaidinfo);
		exit();
		
		/*
		$count = 1;
		foreach ($unpaidinfo as $lm => $val) {
            	$data['student_id'] = $val['student_id'];
           	 $data['created_at'] = date('Y-m-d h:i:s');
			
			
			$sms_id=rand(100000,999999);
			$gsm=$val['mobile'];
			$message='Dear Parents, Please pay the current tuition fee and stay updated. RAJCPSC';
			$username='arerajcpsc';
			$password='arerajcpsc!@#';
			$security_code='arenaapi!@#';
			
			$url = 'http://arenaapps.net/smsenquiry/index.php/home';
						
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec ($ch);
			curl_close ($ch); 	
			
			//$result = substr($output, 0, 4);
			
			if($result==1)
			{
				$data['status']=1;
			}else{
				$data['status']=0;
			}
			
			
		$data['message'] =$message;	
            	$this->smsmodel->payment_message($data);         // add sent message
            	echo $count.'-'.$val['mobile'].'</br>';
           $count++;
           
        }
        
        */
	}
	
	function get_student_number()
	{
			$test = $this->smsmodel->get_student_number();
			
			foreach($test as $val){
			
			 $data['student_id'] = $val['student_id'];
			
			 $data['mobile'] = $val['mobile'];
			 $data['student_number'] = '';
			
			 $this->smsmodel->add_paymentdata($data);
			}
			exit();
	}
	
	function sms_rong_sms_number()
	{
			$testsms = $this->smsmodel->get_student_rong_number();
			
/* 			echo '<pre>';
			print_r($testsms); exit(); */
			
			foreach ($testsms as $lm => $val) {

			
			/*---------- send message config -----------*/
			$sms_id=rand(100000,999999);
			$gsm=$val['mobile'];
			$message='Dear Parents, A message sent yesterday on Tuition fee due into your number was notfor you. Please disregard this message.';
			$username='arerajcpsc';
			$password='arerajcpsc!@#';
			$security_code='arenaapi!@#';
			
			/* $url = 'http://arenaapps.net/smsenquiry/index.php/home';
						
 			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec ($ch);
			curl_close ($ch);	 */
			
			//$result = substr($output, 0, 4);
			if($result==1)
			{
				$data['status']=1;
			}else{
				$data['status']=0;
			}
			
			/*---------- send message config -----------*/
            
        }
			exit();
	}
	
	
	
 }