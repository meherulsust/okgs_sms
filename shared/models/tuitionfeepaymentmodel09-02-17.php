<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * student payment list class 
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 16, 2012
 */
 class Tuitionfeepaymentmodel extends MT_Model
 {
    protected $class_fee = array();
    protected $section_fee = array();
    protected $student_version_fee = array();
	protected $student_type_fee = array();
    protected $common_fee = array();
    protected $admission_fee = array();
	protected $class_fine = array();
    protected $section_fine = array();
    protected $common_fine = array();
    protected $admission_fine = array();
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'student_tuition_fee_payment';
    }
   public function get_columns()
   {
   	  return array('id','student_id','ammount','month','year','pay_status','pay_type','start_date','payment_generate_type','payment_date','expire_date','created_at','created_by','updated_at','updated_by','payment_section_id','payment_class_id');
   }
      
   
	public function get_student_info($class){
		$query = $this->db->select('stv.id  student_id,student_type_id,stv.class_id,section_id,stv.admission_id,sec.version_id,std.extra_facility_id')
		->from('student_academic_v stv')
		->join('student std','std.student_number=stv.student_number','left')
		->join('section sec','sec.id=stv.section_id','left')
		->where('stv.class_id',$class)
		->where('stv.status','ACTIVE')
		->get();
		return $query->result_array();
	}
   
   
	
	public function get_student_info_for_advance_fee($student_number){
		$query = $this->db->select('st.id student_id,stv.student_type_id,st.extra_facility_id,stv.class_id,section_id,stv.admission_id,sec.version_id')
			->from('student st')
			->join('student_academic_v stv','stv.admission_id=st.admission_id','left')
			->join('section sec','sec.id=stv.section_id','left')
			->where('st.student_number',$student_number)
			->where('stv.status','ACTIVE')
			->get();
		return $query->row_array();
	}
	
	
	public function student_payment_info($year,$month)
	{
		$this->db->select('t.id,t.student_id,ammount,a.id admission_id,class_id,section_id');
        $this->db->from('student_tuition_fee_payment t');
		$this->db->join('admission a','a.student_id = t.student_id','left'); 
		$this->db->where('t.year',$year);
		$this->db->where('t.month',$month);
		$this->db->where('t.pay_status','UNPAID');             
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_all_students_detail($class){
            $query = $this->db->select('stv.id  student_id, stv.student_type_id,stv.class_id, stv.section_id, ad.id admission_id,sec.version_id,std.extra_facility_id')
		->from('student_v stv')
		->join('student std','std.student_number=stv.student_number','left')
		->join('section sec','sec.id=stv.section_id','left')
		->join('admission ad','ad.student_id=std.id','left')
		->where('stv.class_id',$class)
		->where('stv.status','Active')
		->get();
		return $query->result_array();
        }
	/*--------------------- Generate student fee -----------------------*/
	
	public function generate_student_fees($class,$year,$month,$start_date,$expire_date,array $students=array()) {
        //process common fee
        $this->load->model('tuitionfeeheadmodel', 'tfhmodel');
        $common_heads = $this->tfhmodel->get_common();
        foreach ($common_heads as $head) {
            $this->common_fee[$head['id']] = array('head_type' => $head['head_type'], 'ammount' => $head['ammount']);
        }
        //process all sections fee  
        $this->_process_class_fee();
        $this->_process_section_fee();
		$this->_process_student_version_fee($class);
		$this->_process_student_type_fee($class);
        $this->_process_admision_fee();
		
        if(empty($students))
//        $students = $this->get_student_info($class);
        $students = $this->get_all_students_detail($class);
        foreach ($students as $std) {
            // check payment config
			$count_payment = $this->check_duplicate_fee($std['student_id'],$year,$month);
			if($count_payment <=0)
			{
				$student_fees = array();
				//if ($std['student_id'] && $std['section_id'] && $std['admission_id']) {
				if ($std['student_id'] && $std['admission_id']) {
					if (isset($this->admission_fee[$std['admission_id']])) {
						$student_fees += $this->admission_fee[$std['admission_id']];
					}
					
					if (isset($this->student_version_fee[$std['student_type_id']][$std['section_id']][$std['version_id']])) {
						$student_fees += $this->student_version_fee[$std['student_type_id']][$std['section_id']][$std['version_id']];
					} elseif(isset($this->student_type_fee[$std['student_type_id']])) {
						$student_fees += $this->student_type_fee[$std['student_type_id']];
					} elseif(isset($this->section_fee[$std['section_id']])) {
						$student_fees += $this->section_fee[$std['section_id']];
					} elseif(isset($this->class_fee[$std['class_id']])) {
						$student_fees += $this->class_fee[$std['class_id']];
					}
					$student_fees += $this->common_fee;
					$payment = array();
					$payment['student_id'] = $std['student_id'];
					$payment['payment_section_id'] = $std['section_id'];
					$payment['month'] = $month;
					$payment['payment_class_id'] = $class;
					$payment['year'] = $year;
					$payment['start_date']=$start_date;
					$payment['expire_date']=$expire_date;
					$payment['created_by'] = 0;
					$payment_id = $this->insert($payment);
					$this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdmodel');
					$total = 0.00;
					foreach ($student_fees as $head_id => $fee) {
						$data['tuition_fee_head_id'] = $head_id;
						$data['student_tuition_fee_payment_id'] = $payment_id;
						if($fee['head_type']=='TRANSPORT' OR $fee['head_type']=='SPECIAL_CLASS')
						{
							if($std['extra_facility_id']== 1 AND $fee['head_type']=='TRANSPORT'){
								$data['ammount'] = $fee['ammount'];
							}elseif($std['extra_facility_id']== 2 AND $fee['head_type']=='SPECIAL_CLASS'){
								$data['ammount'] = $fee['ammount'];
							}elseif($std['extra_facility_id']== 3){
								$data['ammount'] = $fee['ammount'];	
							}else{
								$data['ammount'] = 0.00;
							}
						}else{
							$data['ammount'] = $fee['ammount'];	
						}
						$data['created_by'] = 0;
						$this->tfpdmodel->insert($data);
						if($fee['head_type'] == 'COST' || $fee['head_type'] == 'CONDITIONAL')
							$total +=$fee['ammount'];
						elseif($fee['head_type']=='TRANSPORT' OR $fee['head_type']=='SPECIAL_CLASS')
							$total +=$data['ammount'];							
						elseif($fee['head_type'] == 'WAIVER')
							$total -=$fee['ammount'];
						elseif($fee['head_type'] == 'FINE')
							$total +=0.00;	
					}
					$this->update(array('ammount' => $total, 'id' => $payment_id));
					
				}
			}
		}
    }
	
	
	
	/*--------------------- Generate advance fee -----------------------*/
	
	public function generate_student_advance_fees($student_number,$year,$month,$start_date,$expire_date,array $students=array()) {
        //process common fee
        $this->load->model('tuitionfeeheadmodel', 'tfhmodel');
        $common_heads = $this->tfhmodel->get_common();
        foreach ($common_heads as $head) {
            $this->common_fee[$head['id']] = array('head_type' => $head['head_type'], 'ammount' => $head['ammount']);
        }
        
		// get student info
		$std = $this->get_student_info_for_advance_fee($student_number);  
		
		//process all sections fee  
        $this->_process_class_fee();
        $this->_process_section_fee();
		$this->_process_student_version_fee($std['class_id']);
		$this->_process_student_type_fee($std['class_id']);
        $this->_process_admision_fee();
		
		$student_fees = array();
		//if ($std['student_id'] && $std['section_id'] && $std['admission_id']) {
		if ($std['student_id'] && $std['admission_id']) {
			if (isset($this->admission_fee[$std['admission_id']])) {
				$student_fees += $this->admission_fee[$std['admission_id']];
			}
			
			if (isset($this->student_version_fee[$std['student_type_id']][$std['section_id']][$std['version_id']])) {
				$student_fees += $this->student_version_fee[$std['student_type_id']][$std['section_id']][$std['version_id']];
			} elseif(isset($this->student_type_fee[$std['student_type_id']])) {
				$student_fees += $this->student_type_fee[$std['student_type_id']];
			} elseif(isset($this->section_fee[$std['section_id']])) {
				$student_fees += $this->section_fee[$std['section_id']];
			} elseif(isset($this->class_fee[$std['class_id']])) {
				$student_fees += $this->class_fee[$std['class_id']];
			}
			$student_fees += $this->common_fee;
			$payment = array();
			$payment['student_id'] = $std['student_id'];
			$payment['payment_section_id'] = $std['section_id'];
			$payment['payment_class_id'] = $std['class_id'];
			$payment['month'] = $month;
			$payment['year'] = $year;
			$payment['start_date']= $start_date;
			$payment['expire_date']=$expire_date;
			$payment['payment_generate_type']=1;			
			$payment['created_by'] = 0;
			$payment_id = $this->insert($payment);
			$this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdmodel');
			$total = 0.00;
			foreach ($student_fees as $head_id => $fee) {
				$data['tuition_fee_head_id'] = $head_id;
				$data['student_tuition_fee_payment_id'] = $payment_id;
				if($fee['head_type']=='TRANSPORT' OR $fee['head_type']=='SPECIAL_CLASS')
				{
					if($std['extra_facility_id']== 1 AND $fee['head_type']=='TRANSPORT'){
						$data['ammount'] = $fee['ammount'];
					}elseif($std['extra_facility_id']== 2 AND $fee['head_type']=='SPECIAL_CLASS'){
						$data['ammount'] = $fee['ammount'];
					}elseif($std['extra_facility_id']== 3){
						$data['ammount'] = $fee['ammount'];	
					}else{
						$data['ammount'] = 0.00;
					}
				}else{
					$data['ammount'] = $fee['ammount'];	
				}
				$data['created_by'] = 0;
				$this->tfpdmodel->insert($data);
				if($fee['head_type'] == 'COST' || $fee['head_type'] == 'CONDITIONAL')
					$total +=$fee['ammount'];
				elseif($fee['head_type']=='TRANSPORT' OR $fee['head_type']=='SPECIAL_CLASS')
					$total +=$data['ammount'];
				elseif($fee['head_type'] == 'WAIVER')
					$total -=$fee['ammount'];
				elseif($fee['head_type'] == 'FINE')
					$total +=0.00;	
			}
			$this->update(array('ammount' => $total, 'id' => $payment_id));
			
		}
			
    }
	
	/*--------------------- End Generate advance fee -----------------------*/
	

    private function _process_section_fee() {
        $this->load->model('sectiontuitionfeemodel', 'stfmodel');
        $section_heads = $this->stfmodel->get_fee_info();
        foreach ($section_heads as $sh) {
            $this->section_fee[$sh['section_id']][$sh['tuition_fee_head_id']] = array('head_type' => $sh['head_type'], 'ammount' => $sh['ammount']);
            if (isset($this->class_fee[$sh['class_id']])) {
                $this->section_fee[$sh['section_id']] += $this->class_fee[$sh['class_id']];
            }
        }
    }
	
	private function _process_student_version_fee($class) {
        $this->load->model('studenttypetuitionfeemodel', 'sttfmodel');
        $student_type_heads = $this->sttfmodel->get_version_fee_info($class);
        foreach ($student_type_heads as $sth) {			
			$this->student_version_fee[$sth['student_type_id']][$sth['section_id']][$sth['version_id']][$sth['tuition_fee_head_id']] = array('head_type' => $sth['head_type'], 'ammount' => $sth['ammount']);
			if (isset($this->section_fee[$sth['section_id']])) {
                $this->student_version_fee[$sth['student_type_id']][$sth['section_id']][$sth['version_id']] += $this->section_fee[$sth['section_id']];
            }else if (isset($this->class_fee[$sth['class_id']])) {
                $this->student_version_fee[$sth['student_type_id']][$sth['section_id']][$sth['version_id']] += $this->class_fee[$sth['class_id']];
            }
		}
    }	
	
	private function _process_student_type_fee($class) {
        $this->load->model('studenttypetuitionfeemodel', 'sttfmodel');
        $student_type_heads = $this->sttfmodel->get_fee_info($class);
        foreach ($student_type_heads as $sth) {
            $this->student_type_fee[$sth['student_type_id']][$sth['tuition_fee_head_id']] = array('head_type' => $sth['head_type'], 'ammount' => $sth['ammount']);            
			if (isset($this->section_fee[$sth['section_id']])) {
                $this->student_type_fee[$sth['student_type_id']] += $this->section_fee[$sth['section_id']];
            }else if (isset($this->class_fee[$sth['class_id']])) {
                $this->student_type_fee[$sth['student_type_id']] += $this->class_fee[$sth['class_id']];
            }
		}
    }

    private function _process_class_fee() {
        $this->load->model('classtuitionfeemodel', 'ctfmodel');
        $class_heads = $this->ctfmodel->get_fees();
        foreach ($class_heads as $ch) {
            $this->class_fee[$ch['class_id']][$ch['tuition_fee_head_id']] = array('head_type' => $ch['head_type'], 'ammount' => $ch['ammount']);
        }
    }

    private function _process_admision_fee() {
        $this->load->model('admissionfeemodel', 'adfmodel');
        $admission_heads = $this->adfmodel->get_fees();
        foreach ($admission_heads as $ad) {
            $this->admission_fee[$ad['admission_id']][$ad['tuition_fee_head_id']] = array('ammount' => $ad['ammount'], 'head_type' => $ad['head_type']);
        }
    }
	
	
	/*--------------------- End Generate student fee -----------------------*/
	
	
	/*--------------------- Generate student fine -----------------------*/
	
	public function generate_student_fine($year,$month,array $students=array()) {
        //process common fee
        $this->load->model('tuitionfeeheadmodel', 'tfhmodel');
        $fine_heads = $this->tfhmodel->get_fine();
        foreach ($fine_heads as $head) {
            $this->common_fine[$head['id']] = array('head_type' => $head['head_type'], 'ammount' => $head['ammount']);
        }
        //process all sections fee  
        $this->_process_class_fine();
        $this->_process_section_fine();
        $this->_process_admision_fine();
        if(empty($students))
        $students = $this->student_payment_info($year,$month);
        
		foreach ($students as $std) {
            
			$student_fine = array();
            if ($std['student_id'] && $std['section_id'] && $std['admission_id']) {
                if (isset($this->admission_fine[$std['admission_id']])) {
                    $student_fine += $this->admission_fine[$std['admission_id']];
                }
                if (isset($this->section_fine[$std['section_id']])) {
                    $student_fine += $this->section_fine[$std['section_id']];
                } elseif(isset($this->class_fine[$std['class_id']])) {
                    $student_fine += $this->class_fine[$std['class_id']];
                }
                $student_fine += $this->common_fine;
                /* $payment = array();
                $payment['student_id'] = $std['student_id'];
                $payment['month'] = $month;
                $payment['year'] = $year;
                $payment['created_by'] = 0; */
                $payment_id = $std['id'];
				$ammount=$std['ammount'];
				
                $this->load->model('tuitionfeepaymentdetailsmodel', 'tfpdmodel');
                $total = 0.00;
                foreach ($student_fine as $head_id => $fee) {
                    $data['tuition_fee_head_id'] = $head_id;
                    $data['student_tuition_fee_payment_id'] = $payment_id;
                    $data['ammount'] = $fee['ammount'];
                    $data['created_by'] = 0;
                    $this->tfpdmodel->insert($data);
                    if($fee['head_type'] == 'FINE')
                    $total +=$fee['ammount'];
                    
                }
                $update_total=$total+$ammount;				
				$this->update(array('ammount' => $update_total, 'id' => $payment_id));
                
            }
        }
    }

    private function _process_section_fine() {
        $this->load->model('sectiontuitionfeemodel', 'stfmodel');
        $section_heads = $this->stfmodel->get_fine_info();
        foreach ($section_heads as $sh) {
            $this->section_fine[$sh['section_id']][$sh['tuition_fee_head_id']] = array('head_type' => $sh['head_type'], 'ammount' => $sh['ammount']);
            if (isset($this->class_fine[$sh['class_id']])) {
                $this->section_fine[$sh['section_id']] += $this->class_fine[$sh['class_id']];
            }
        }
    }

    private function _process_class_fine() {
        $this->load->model('classtuitionfeemodel', 'ctfmodel');
        $class_heads = $this->ctfmodel->get_fine();
        foreach ($class_heads as $ch) {
            $this->class_fine[$ch['class_id']][$ch['tuition_fee_head_id']] = array('head_type' => $ch['head_type'], 'ammount' => $ch['ammount']);
        }
    }

    private function _process_admision_fine() {
        $this->load->model('admissionfeemodel', 'adfmodel');
        $admission_heads = $this->adfmodel->get_fine();
        foreach ($admission_heads as $ad) {
            $this->admission_fine[$ad['admission_id']][$ad['tuition_fee_head_id']] = array('ammount' => $ad['ammount'], 'head_type' => $ad['head_type']);
        }
    }
	
	
	
	/*--------------------- End student fine -----------------------*/
	
	
   public function get_student_orignal_fee_by_head($student_id,$head_id,$params=array()){
       if(isset($params['admission_id'])&& !isset($params['class_id']) && !isset($params['section_id'])){
            $admission_id = $params['admission_id'];
            $class_id = $params['class_id'];
            $section_id = $params['section_id'];
       }else{
        $this->load->model('studentacademicvmodel','sarv');
        $std_info = $this->sarv->find($student_id);
        $admission_id = $std_info['admission_id'];
        $class_id = $std_info['class_id'];
        $section_id = $std_info['section_id'];
       }
        $sql = "SELECT id, head_code, COALESCE(adt.ammount, stdt.ammount,st.ammount,ct.ammount,t.ammount) tuion_fee FROM sms_tuition_fee_head t"
               ." LEFT JOIN (SELECT tuition_fee_head_id, ammount  FROM sms_class_tuition_fee WHERE class_id='$class_id') ct ON ct.tuition_fee_head_id = t.id"
               ." LEFT JOIN (SELECT tuition_fee_head_id, ammount  FROM sms_section_tuition_fee WHERE section_id='$section_id') st ON st.tuition_fee_head_id = t.id"
               ." LEFT JOIN (SELECT tuition_fee_head_id, ammount  FROM sms_student_tuition_fee WHERE student_id='$student_id') stdt ON stdt.tuition_fee_head_id = t.id"
               ." LEFT JOIN (SELECT tuition_fee_head_id, ammount  FROM sms_admission_tuition_fee WHERE admission_id='$admission_id) adt ON adt.tuition_fee_head_id = t.id"
                ." WHERE id = '$head_id'";
        $query = $this->db->query($sql);
        $row = array();
        if ($query->num_rows() > 0)
        {
             $row = $query->row_array();
        } 
        return $row; 
   }
   
	public function get_student_fee($student_id){
		$this->db->select('t.id,student_id,ammount,month,year,pay_status,pay_type,start_date,expire_date,payment_generate_type,t.created_at,t.created_by,t.updated_at,pt.bank_transection_id');
        $this->db->from('student_tuition_fee_payment t');
        $this->db->join('student_payment_transection pt','pt.student_tuition_fee_payment_id = t.id','left');
		$this->db->where('t.student_id',$student_id);		
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
   
   public function student_payment_report(){
       $query = $this->db->select('t.id,t.start_date,DATE(payment_date) as pay_date,expire_date,MONTHNAME(STR_TO_DATE(month, "%m")) as month_name,year,ammount,pay_status,t.created_at,st.student_number,class_roll,full_name,student_type,cl.title class,se.title section',false)
               ->from('student_tuition_fee_payment t')
			   ->join('class cl','cl.id = t.payment_class_id','left')
               ->join('section se','se.id = t.payment_section_id','left')
               ->join('student_v st','st.id = t.student_id','left');             
       return $query;
   }
   
   public function student_payment_report_count(){
       $query = $this->db->select('t.id')
			   ->from('student_tuition_fee_payment t')	
               ->join('class cl','cl.id = t.payment_class_id','left')
               ->join('section se','se.id = t.payment_section_id','left')
               ->join('student_v st','st.id = t.student_id','left'); 
       return $query->count_all_results();
   }
   
   public function get_student_min_info($id){
		$sql = $this->db->select('t.id, student_number,c.title class,s.title section,class_roll,first_name,last_name,MONTHNAME(STR_TO_DATE(month, "%m")) as month_name,year,ammount,pay_status,t.created_at,sp.file_name,p.mobile,photo_id',false)
               ->from('student_tuition_fee_payment t')
               ->join('admission a','t.student_id = a.student_id','left') 
               ->join('student std','std.id = t.student_id', 'left')
               ->join('personal_details p','personal_details_id = p.id','left')
    	       ->join('section s','s.id = a.section_id', 'left')
    	       ->join('class c','c.id = s.class_id','left')
			   ->join('student_photo sp','sp.id = std.photo_id','left')
			   ->where('t.id',$id);
        $query = $sql->get();
       return $query->row_array();         
	}
   
   
	public function get_all_student_min_info($sdata)
	{
		$this->db->select('t.id,t.start_date,t.expire_date,payment_generate_type,student_number,c.id class_id,c.title class,s.title section,class_roll,first_name,last_name,month,year,ammount,pay_status,payment_date,t.created_at,house.title house_name');
        $this->db->from('student_tuition_fee_payment t');
		$this->db->join('admission a','t.student_id = a.student_id','left'); 
		$this->db->join('student std','std.id = t.student_id', 'left');
		$this->db->join('personal_details p','personal_details_id = p.id','left');
		$this->db->join('section s','s.id = a.section_id', 'left');
		$this->db->join('class c','c.id = a.class_id','left');
		$this->db->join('student_house sth','sth.student_id = t.student_id','left');
		$this->db->join('house','house.id = sth.house_id','left');
		$this->db->order_by('c.serial','ASC');
		$this->db->order_by('class_roll','ASC');
		if($sdata['class_id']!=''){
			$this->db->where('t.payment_class_id',$sdata['class_id']);
		}
		if($sdata['section_id']!=''){
			$this->db->where('t.payment_section_id',$sdata['section_id']);
		}	
		if($sdata['pay_status']!='0'){
			$this->db->where('t.pay_status',$sdata['pay_status']);
		}
		if($sdata['year']!='0'){
			$this->db->where('t.year',$sdata['year']);
		}
		if($sdata['month']!='0'){
			$this->db->where('t.month',$sdata['month']);
		}
		if($sdata['payment_mode']!=''){
			$this->db->where('t.payment_generate_type',$sdata['payment_mode']);
		}
		if($sdata['day_from']!='' AND $sdata['day_to']!=''){
			$this->db->where('DATE(t.payment_date) >=',$sdata['day_from']);
			$this->db->where('DATE(t.payment_date) <=',$sdata['day_to']);
		}
		if($sdata['day_from']!='' AND $sdata['day_to']==''){
			$this->db->where('DATE(t.payment_date)',$sdata['day_from']);
		}
		if($sdata['day_from']=='' AND $sdata['day_to']!=''){
			$this->db->where('DATE(t.payment_date)',$sdata['day_to']);
		}
		if($sdata['student_number']!=''){
			$this->db->where('std.student_number',$sdata['student_number']);
		}
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
   
	public function count_all_student_min_info($sdata)
	{

		$this->db->select('t.id');
        $this->db->from('student_tuition_fee_payment t');
		$this->db->join('admission a','t.student_id = a.student_id','left'); 
		$this->db->join('student std','std.id = t.student_id', 'left');
		$this->db->join('personal_details p','personal_details_id = p.id','left');
		$this->db->join('section s','s.id = a.section_id', 'left');
		$this->db->join('class c','c.id = a.class_id','left');
		$this->db->order_by('c.serial','ASC');
		if($sdata['class_id']!=''){
			$this->db->where('t.payment_class_id',$sdata['class_id']);
		}
		if($sdata['section_id']!=''){
			$this->db->where('t.payment_section_id',$sdata['section_id']);
		}	
		if($sdata['pay_status']!='0'){
			$this->db->where('t.pay_status',$sdata['pay_status']);
		}
		if($sdata['year']!='0'){
			$this->db->where('t.year',$sdata['year']);
		}
		if($sdata['month']!='0'){
			$this->db->where('t.month',$sdata['month']);
		}
		if($sdata['payment_mode']!=''){
			$this->db->where('t.payment_generate_type',$sdata['payment_mode']);
		}
		if($sdata['day_from']!='' AND $sdata['day_to']!=''){
			$this->db->where('DATE(t.payment_date) >=',$sdata['day_from']);
			$this->db->where('DATE(t.payment_date) <=',$sdata['day_to']);
		}
		if($sdata['day_from']!='' AND $sdata['day_to']==''){
			$this->db->where('DATE(t.payment_date)',$sdata['day_from']);
		}
		if($sdata['day_from']=='' AND $sdata['day_to']!=''){
			$this->db->where('DATE(t.payment_date)',$sdata['day_to']);
		}
		if($sdata['student_number']!=''){
			$this->db->where('std.student_number',$sdata['student_number']);
		}
		//$query = $this->db->get();	
        return $this->db->count_all_results();
	}
	
	
	
	
	public function get_student_tuition_fee_payment_id($param)
	{
		
		$this->db->select('t.id,s.student_number');
        $this->db->from('student_tuition_fee_payment t');
		$this->db->join('student s','s.id = t.student_id','left'); 
		$this->db->where('s.student_number',$param['student_id']);
		$this->db->where('t.year',$param['year']);
		$this->db->where('t.month',$param['month']);
		$query = $this->db->get();
		return $query->row_array();
		
	}
	
	public function update_tuition_fee_payment($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('student_tuition_fee_payment',$data);
	}
	
	public function update_transaction_id($id,$data)
	{
		$this->db->where('student_tuition_fee_payment_id',$id);
		$this->db->update('student_payment_transection',$data);
	}
	
	
	public function check_duplicate_fine($year,$month)
	{
		$query = $this->db->from('student_tuition_fee_payment t')
               ->join('student_tuition_fee_payment_details pd','pd.student_tuition_fee_payment_id = t.id','left') 
               ->join('tuition_fee_head fh','fh.id = pd.tuition_fee_head_id','left')
               ->where('t.year',$year)
    	       ->where('t.month',$month)
    	       ->where('fh.head_type','FINE')
			   ->where('fh.status',1);
		return $query->count_all_results();
	}
	
	
	public function get_payment_details($id)
	{		
		$this->db->select('id,pay_status,pay_type,payment_date,payment_generate_type');
        $this->db->from('student_tuition_fee_payment');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
		
	}
	
	public function check_duplicate_fee($student_id,$year,$month)
	{
		$query = $this->db->from('student_tuition_fee_payment t')
               ->where('t.student_id',$student_id)
    	       ->where('t.year',$year)
    	       ->where('t.month',$month);
		return $query->count_all_results();
	}
	
	public function check_advance_duplicate_fee($data)
	{
		$query = $this->db->from('student_tuition_fee_payment t')
               ->where('t.student_id',$data['student_id'])
    	       ->where('t.year',$data['year'])
    	       ->where('t.month',$data['month'])
    	       ->where('t.pay_status','PAID')
			   ->where('t.payment_generate_type',1);
		return $query->count_all_results();
	}
	
	public function get_paymeny_month($data)
	{
		$this->db->select('t.month');
		$this->db->from('student_tuition_fee_payment t');
		$this->db->join('student s','s.id = t.student_id','left');
		$this->db->where('t.year',$data['year']);
		$this->db->where('s.student_number',$data['student_number']); 
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	public function transection_data($data1){	
		$this->db->insert('student_payment_transection',$data1);
		return $this->db->insert_id();	
	}
	public function advp_data($data,$id){
		$this->db->update('student_tuition_fee_payment', $data, array('id' => $id));
		
	}
	
	
   
 }
?>