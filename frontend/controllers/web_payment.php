<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Web_payment extends FRONTEND_Controller{
    function __construct()
    {
        $this->set_ignore_auth('web_payment');
		parent::__construct();
		$this->tpl->set_view(false);
        $this->tpl->set_layout(false);
    }

	function confirm_payment()
  	{		
		if($_GET['status']=='SUCCESS')
		{
			$id = $_GET['application_id'];
			$data['payment_status'] = 'Paid';
			$data['transaction_id'] = $_GET['transaction_id'];
			$data['payment_date'] = $this->current_datetime();
			$data['agent'] = $_GET['agent'];
			$this->load->model('paymentmodel');
			$update_row = $this->paymentmodel->update_temp_payment($id,$data);  // update data
			if($update_row)
			{
				echo '1';
			}else{
				echo '0';
			}			
		}else{
			echo '0';
		}		 
	}
	
 }