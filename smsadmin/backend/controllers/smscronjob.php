<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * School Management System Cron Job class running by system cron job
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 16, 2014
 */
class Smscronjob extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
   public function generatetuitionfee(){
      $this->load->model('tuitionfeepaymentmodel');
      $this->tuitionfeepaymentmodel->generate_student_fees();
      echo 'done'.PHP_EOL;;
   }
   
   public function sendsms(){
       $this->load->model('sentmessagemodel','smsm');
       $this->smsm->send_sms();
   }
   
    private function call_sms_api($msg){
           $params['sms_id']=rand(100000,999999);
           $params['gsm']=$msg['mobile'];
           $params['message']=$msg['text'];
           $params['username']='school_demo';
           $params['password']='school_demo';
           $params['security_code']='arenaapi!@#';
           $url = 'http://arenaapps.net/smsenquiry/index.php/home';
   }
   
}