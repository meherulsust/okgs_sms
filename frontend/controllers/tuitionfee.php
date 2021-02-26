<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Tuitionfee extends Frontend_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {		

    }
    function create(){
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
    
    public function save(){
        $this->load->model('studentvmodel');
        $student_number = $this->auth->get_user()->student_number;
        $row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
        $this->load->model('studenttuitionfeemodel');
        $fees = $this->studenttuitionfeemodel->get_student_fee($row['id']);
        $total = 0;
        foreach($fees as $fee){
            if($fee['head_type']=='COST')
            $total += $fee['amount'];
            elseif($fee['head_type']=='WAIVER')
            $total -= $fee['amount'];  
        }
       echo $total;
       exit();
        
    }
	
	
	
 }
