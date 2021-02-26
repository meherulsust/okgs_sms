<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 17, 2011
 */
class BACKEND_Controller extends MT_Controller {

    function __construct() {
        parent::__construct();
		$this->db_config();
        $this->init_template();
        $this->_load_libs();
        
    }
	
	private function db_config()
	{
		
		if($this->session->userdata('db_postfix') != ''){
			$db_postfix = $this->session->userdata('db_postfix');
			$db_name = 'okgs_sms_db'.$db_postfix;
		}else{
			$db_name = 'okgs_sms_db';
		}
		
		$db['hostname'] = 'localhost';
		$db['username'] = 'root';
		$db['password'] = '';
		$db['database'] = $db_name;
		$db['dbdriver'] = 'mysqli';
		$db['dbprefix'] = 'sms_';
		$db['pconnect'] = TRUE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = '';
		$db['char_set'] = 'utf8';
		$db['dbcollat'] = 'utf8_general_ci';
		$db['swap_pre'] = '';
		$db['autoinit'] = TRUE;
		$db['stricton'] = FALSE;
		$this->load->database($db);		
	}

    protected function init_template() {
        $this->tpl->set_image_dir('img');
        if ($this->input->is_ajax_request()) {
            $this->init_ajax_template();
        } else {
            $this->tpl->set_page_title('OKGS');
            $this->tpl->set_layout('smslayout');
            $this->tpl->set_js(array('jquery-1.7.2','smsadmin'));
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
        $this->load->library('Pmt_menu', null, 'menu');
        $this->tpl->assign('mt_menu', $this->menu);
    }

    protected function validate_form() {
        $config = $this->get_validation_rule();
        $this->load->library('form_validation', null, 'validator');
        $this->validator->set_error_delimiters('<label class="error">', '</label>');
        $this->validator->set_rules($config);
        return $this->validator->run();
    }

    protected function get_validation_rule() {
        show_error('No validation rule is found.');
    }
	
    function send_sms_imsn($mobile_no,$message)
    {
        $username='imsnadmin';
        $password='imsn321';
        $mobile_no = $mobile_no;
        $message = $message;
        
        $url = 'http://202.126.120.118/smsenquiry/index.php/sms_api/send_sms';	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&mobile_no=$mobile_no&message=$message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec ($ch);
        curl_close ($ch);	
        $result = json_decode($output);
        if($result->status == 1)
        {
                return 1;
        }else{
                return 0;
        }
    }
    

}

?>