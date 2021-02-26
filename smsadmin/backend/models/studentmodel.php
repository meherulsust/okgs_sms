<?php

class Studentmodel extends BACKEND_Model {
    protected $xls_fields = array();
    public function __construct() {
        parent::__construct();
    }

    public function grid_query() {
        $this->db->select('s.id,student_number,first_name,gender,s.created_at,mobile,st.title status')
                ->from('student s')
                ->join('status st', 'status_id = st.id', 'left')
                ->join('personal_details p', 'personal_details_id = p.id', 'left');
    }

    public function get_details_info($student_id) {
        $this->db->select('s.id,student_number,personal_details_id,father_guardian_id,mother_guardian_id,local_guardian_id,first_name,last_name,lower(gender) gender,
   	  					s.created_at,mobile,st.title status,present_address_id,permanent_address_id,photo_id,file_name,image_size,
   	  					date_format(s.created_at,"%D %b,%Y") as created_on,date_format(p.updated_at,"%D %b,%Y") as updated_on,date_format(dob,"%D %b,%Y") as dob,p.email,lower(is_tribe) tribe,
   	  					u.username created_by,uu.username updated_by,p.comments,n.title nationality,
   	  					r.title religion,c.title caste, cls.title class, sec.title section', false)
                ->from('student s')
                ->join('status st', 'status_id = st.id', 'left')
                ->join('personal_details p', 'personal_details_id = p.id', 'left')
                ->join('religion_caste c', 'caste_id = c.id', 'left')
                ->join('religion r', 'religion_id = r.id', 'left')
                ->join('user u', 's.created_by = u.id', 'left')
                ->join('user uu', 'p.updated_by = u.id', 'left')
                ->join('nationality n', 'nationality_id = n.id', 'left')
                ->join('student_photo sp', 'photo_id = sp.id', 'left')
                ->join('admission a','a.id = s.admission_id', 'left')
                ->join('class cls','cls.id = a.class_id', 'left')
                ->join('section sec','sec.id = a.section_id', 'left')
                ->where('s.id', $student_id);
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    function get_student_details($id)
 	{ 
		$this->db->select('student.id,student.student_number,CONCAT(pd.first_name," ",pd.last_name) as full_name
		,pd.dob,ad.birth_regino birth_reg_no,nationality.title nationality,pd.gender gender,pd.is_tribe,
		religion.title religion,blood_group.title blood_group,
		class.title class,sec.title section,student_type.title student_type,ad.class_roll,board_roll,board_regino,index_no,ad.comments,ad.session student_session,ad.index_no,
		version_list.title version,CONCAT(gd.first_name," ",gd.last_name) as father_name,CONCAT(gd1.first_name," ",gd1.last_name) as mother_name,
		gd.mobile father_mobile,gd.national_id father_national_id,gd1.national_id mother_national_id,
		gd1.mobile mother_mobile,gd1.anual_income mother_monthly_income,
		occupation.title father_occupation,occ.title mother_occupation,occ1.title local_guardian_occupation,
		gd.anual_income father_monthly_income,relationship.title relationship,
		CONCAT(gd2.first_name," ",gd2.last_name) as local_guardian_name,gd2.mobile local_guardian_mobile,gd2.national_id local_guardian_national_id,gd2.anual_income local_guardian_monthly_income,
		address.address_line present_address,district.name present_district,
		thana.name present_thana,post_office.name present_post,add1.address_line parmanent_address,dit.name parmanent_district,
		th.name parmanent_thana,po.name parmanent_post,
		student_photo.file_name image_file',false);
		
 	 	$this->db->from('student');
 	 	$this->db->join('personal_details pd','pd.id=student.personal_details_id','left');
		$this->db->join('admission ad','ad.id=student.admission_id','left');
		
		$this->db->join('religion_caste c', 'c.id=pd.caste_id', 'left');
        $this->db->join('religion','religion.id=c.religion_id','left');
		$this->db->join('blood_group','blood_group.id=pd.blood_group_id','left');
		$this->db->join('class','class.id=ad.class_id','left');
		$this->db->join('student_type','student_type.id=ad.student_type_id','left');
		$this->db->join('section sec','sec.id=ad.section_id','left');
		$this->db->join('version_list','version_list.id=sec.version_id','left');
		$this->db->join('guardian gd','gd.id=student.father_guardian_id','left');
		$this->db->join('guardian gd1','gd1.id=student.mother_guardian_id','left');
		$this->db->join('student_guardian stgd','stgd.guardian_id=student.local_guardian_id','left');
		$this->db->join('guardian gd2','gd2.id=stgd.guardian_id','left');
		$this->db->join('relationship','relationship.id=stgd.relationship_id','left');
		$this->db->join('nationality','nationality.id=pd.nationality_id','left');
		
		$this->db->join('occupation','occupation.id=gd.occupation_id','left');
		$this->db->join('occupation occ','occ.id=gd1.occupation_id','left');
		$this->db->join('occupation occ1','occ1.id=gd2.occupation_id','left');
		
		$this->db->join('student_address','student_address.id=student.present_address_id','left');
		$this->db->join('address','address.id=student_address.id','left');
		$this->db->join('district','district.id=address.district','left');
		$this->db->join('thana','thana.id=address.thana','left');
		$this->db->join('post_office','post_office.id=address.post_office_id','left');
		
		$this->db->join('student_address st','st.id=student.permanent_address_id','left');
		$this->db->join('address add1','add1.id=st.id','left');
		$this->db->join('district dit','dit.id=add1.district','left');
		$this->db->join('thana th','th.id=add1.thana','left');
		$this->db->join('post_office po','po.id=add1.post_office_id','left');
		
		
		
		$this->db->join('student_photo','student_photo.id=student.photo_id ','left');  
		
 		$this->db->where('student.id',$id);
		$query = $this->db->get();
        return $query->row_array();
 	}
    
    	
    public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('student s')
                ->join('personal_details p', 'personal_details_id = p.id', 'left');
        return $query->count_all_results();
    }

    public function save(array $data) {
        //$data['student_number'] = $this->generate_student_number();
        $this->db->trans_start();
        $data['student_id'] = $this->insert($data);
        $this->load->model('personaldetailsmodel', 'pdm');
        
        $this->pdm->save($data);
        $this->load->model('studentstatusmodel');
        $this->load->helper('lookup');
        $data['lookup_id'] = lookup_id('STD_STAT_CHANGE_REASON', 'ADMISSION_IN_PROGRESS ');
        $data['status_id'] = 3;
        $this->studentstatusmodel->save($data);
        $this->db->trans_complete();
        return $data['student_id'];
    }
    
    public function update_std_number($id,$data)
    {        
	$this->db->update('student',$data,array('id'=>$id));
    }

    public function count_student_number($std_number,$param)
    {
	$this->db->select('id');	
 	$this->db->from('student');	
	$this->db->where('student_number',$std_number);
	if($param)
	$this->db->where('student_number <>',$param);	
	$rs=$this->db->get();	    
	return $rs->num_rows();
    }

    public function save_guardian() {
        $this->load->model('guardianmodel');
        $this->load->model('studentguardianmodel', 'sdm');
        $vals = $this->sdm->get_default_values();
    }

    public function get_table_name() {
        return 'student';
    }

    public function get_columns() {
        return array('id','extra_facility_id','student_number');
    }

    public function get_status($std_id) {
        $query = $this->db->select('title,status_id,student_id')
                ->from('student_status ss')
                ->join('status s', 'ss.status_id = s.id', 'left')
                ->where('student_id', $std_id)
                ->get();
        return $query->row_array();
    }

    /* public function generate_student_number() {
        $year = date('Y');
        $this->db->select_max('student_number')->from('student');
        $max_num = $this->get_one();
        if ($max_num) {
            $nyear = substr($max_num, 0, 4);
            if ($nyear == $year) {
                return $max_num + 1;
            } elseif (($nyear + 1) == $year) {
                return $year . sprintf('%03d', 1);
            }
        }else{
             return $year . sprintf('%03d', 1);
        }
    } */
	
	public function generate_student_number() {
        $year = date('Y');
        $this->db->select_max('id')->from('student');
        $max_num = $this->get_one();
        return $year.sprintf('%06d', $max_num+1);        
    }

    public function find_info_by_number($number) {
        $query = $this->db->select('s.id,student_number,p.first_name,p.last_name,gender,p.mobile,p.email,sec.title section,cls.title class,
   	  					st.title status,file_name,image_size,photo_id,g.first_name father_name1,g.last_name father_name2,
   	  					date_format(s.created_at,"%D %b,%Y") as created_on,date_format(p.updated_at,"%D %b,%Y") as updated_on,date_format(dob,"%D %b,%Y") as dob,
                                                p.email,lower(is_tribe) tribe,class_roll,
   	  					u.username created_by,uu.username updated_by,p.comments,n.title nationality,
   	  					r.title religion,c.title caste', false)
                ->from('student s')
                ->join('status st', 'status_id = st.id', 'left')
                ->join('personal_details p', 'personal_details_id = p.id', 'left')
                ->join('guardian g', 'father_guardian_id = g.id', 'left')
                ->join('religion_caste c', 'caste_id = c.id', 'left')
                ->join('religion r', 'religion_id = r.id', 'left')
                ->join('user u', 's.created_by = u.id', 'left')
                ->join('user uu', 'p.updated_by = u.id', 'left')
                ->join('nationality n', 'nationality_id = n.id', 'left')
                ->join('student_photo sp', 'photo_id = sp.id', 'left')
                ->join('admission a', 'a.student_id = s.id', 'left')
                ->join('section sec', 'a.section_id = sec.id', 'left')
                ->join('class cls', 'sec.class_id = cls.id', 'left')
                ->where('s.student_number', $number)
                ->get();
        return $query->row_array();
    }

    public function delete($info) {
        $this->db->trans_start();
        if ($info['personal_details_id']) {
            $this->load->model('Studentpersonaldetailsmodel', 'spdm');
            $pdids = $this->spdm->get_field('personal_details_id', array('student_id' => $info['id']));
            $this->load->model('personaldetailsmodel');
            $this->personaldetailsmodel->delete_where_in($pdids);
            $this->spdm->delete_where(array('student_id' => $info['id']));
        }
        if ($info['status_id']) {
            $this->load->model('studentstatusmodel', 'ssm');
            $this->ssm->delete_where(array('student_id' => $info['id']));
        }
        if ($info['father_guardian_id'] || $info['mother_guardian_id'] || $info['local_guardian_id']) {
            $this->load->model('studentguardianmodel', 'sgm');
            $gids = $this->sgm->get_field('guardian_id', array('student_id' => $info['id']));
            $this->load->model('guardianmodel');
            $this->guardianmodel->delete_where_in($gids);
            $this->sgm->delete_where(array('student_id' => $info['id']));
        }
        if ($info['present_address_id'] || $info['present_address_id']) {
            $this->load->model('studentaddressmodel', 'sam');
            $aids = $this->sam->get_field('address_id', array('student_id' => $info['id']));
            $this->load->model('addressmodel');
            $this->addressmodel->delete_where_in($aids);
            $this->sam->delete_where(array('student_id' => $info['id']));
        }
        parent::delete($info['id']);
        $this->db->trans_complete();
    }

    public function get_guardian($std_id, $type) {
        switch ($type) {
            case 'father':
                $field = 'father_guardian_id';
                break;
            case 'mother':
                $field = 'mother_guardian_id';
                break;
            default:
                $field = 'guardian_id';
                break;
        }
        $query = $this->db->select('g.id,first_name,last_name,mobile,phone,anual_income,email,occupation_id,national_id,designation_id,service_no')
                ->from('student s')
                ->join('guardian g', 's.' . $field . ' = g.id', 'right')
                ->where('s.id', $std_id)
                ->get();
        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }

    public function get_address($std_id, $type) {
        $query = $this->db->select('a.id,address_line,post_office_id,thana_id,district_id')
                ->from('student s')
                ->join('address a', 's.' . $type . '_address_id = a.id', 'right')
                ->join('post_office p', 'p.id = a.post_office_id', 'left')
                ->join('thana t', 't.id = p.thana_id', 'left')
                ->where('s.id', $std_id)
                ->get();
        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }
    
    public function save_bulk_data($data){
        $results = $this->process_bulk_data($data);
        $this->load->model(array('addressmodel','postofcmodel','guardianmodel','relationshipmodel','occupationmodel','admissionmodel','sectionmodel'));
       foreach($results['personal'] as $i=>$row){
            $row['id'] = '';
            $student_id = $this->save($row);
            if(isset($results['permanent'][$i])){
                $addr = $this->postofcmodel->get_address_by_post($results['permanent'][$i]['post_code']);
               if($addr){
                    $addr['student_id'] = $student_id;
                    $addr['address_line'] = $results['permanent'][$i]['address_line'];
                    $addr['id'] = '';
                    $addr['address_type'] = 'PERMANENT';
                    $this->addressmodel->save($addr);
               }
            }  
            if(isset($results['present'][$i])){
               if(isset($results['present'][$i]['same']) && strtoupper($results['present'][$i]['same']) == 'YES'){
                    $addr['address_type'] = 'PRESENT';
               }else{
                   unset($addr);
                    $addr = $this->postofcmodel->get_address_by_post($results['present'][$i]['post_code']);
                   if($addr){
                       $addr['student_id'] = $student_id;
                       $addr['address_line'] = $results['present'][$i]['address_line'];
                       $addr['id'] = '';
                       $addr['address_type'] = 'PRESENT';
                   }
               }
              $this->addressmodel->save($addr);
            }
             if(isset($results['father'][$i])){
                $father = $results['father'][$i];
                $father['student_id'] = $student_id;
                $father['id'] = '';
                $father['occupation_id'] = $this->occupationmodel->find_one_by('id',array('title'=>$father['occupation_id']));
                $father['relationship_id']=2;
                $this->guardianmodel->save($father);
             }
            if(isset($results['mother'][$i])){
                $mother = $results['mother'][$i];
                $mother['id'] = '';
                $mother['student_id'] = $student_id;
                $mother['occupation_id'] = $this->occupationmodel->find_one_by('id',array('title'=>$mother['occupation_id']));
                $mother['relationship_id']=1;
                $this->guardianmodel->save($mother);
            }
             if(isset($father) && strtoupper($results['guardian'][$i]['relation']) == 'FATHER'){
               $father['relationship_id']='30';
               $this->guardianmodel->save($father);
            }elseif(isset($mother) && strtoupper($results['guardian'][$i]['relation']) == 'MOTHER'){
                $mother['relationship_id']='29';
                $this->guardianmodel->save($mother); 
            }elseif(isset($results['guardian'][$i])){
                $guardian = $results['guardian'][$i];
                $guardian['id'] = '';
                $guardian['student_id'] = $student_id;
                $guardian['occupation_id'] = $this->occupationmodel->find_one_by('id',array('title'=>$guardian['occupation_id']));
                $guardian['relationship_id']= $this->relationshipmodel->find_one_by('id',array('title'=>$guardian['relation']));
                $this->guardianmodel->save($guardian); 
            }
           if(isset($results['admission'][$i])){
               $admission = $results['admission'][$i];
               $ids = $this->sectionmodel->get_id_by_title(array('class'=>$admission['class_id'],'section'=>$admission['section_id']));
               $admission['id'] = '';
               $admission['sylabus_id'] = '';
               $admission['student_id'] = $student_id;
               $admission['section_id'] = $ids['section_id'];
               $admission['class_id'] = $ids['class_id'];;
               $this->admissionmodel->save($admission);
           }
       }
      
    }
    
    protected function process_bulk_data($data){
        $this->set_xls_fields();
        $results = array();
        $this->load->helper('date');
        $this->load->model(array('nationalitymodel','castemodel'));
        foreach($data as $tab=>$rs){
            $fields = $rs[1];
            unset($rs[1]);
            switch ($tab){
                case 'personal':
                     foreach($rs as $j=>$row){
                            unset($row['A']);
                            foreach($row as $i=>$f){
                               $field = $this->xls_fields[$tab][$fields[$i]];
                                switch($field){
                                    case 'dob':
                                        $f = empty($f)? '': format_date($f);
                                        break;
                                    case 'nationality_id':
                                        $f = $this->nationalitymodel->find_one_by('id',array('title'=>$f));
                                        break;
                                    case 'caste_id':
                                        $f= $this->castemodel->find_one_by('id',array('title'=>$f));
                                        break;
                                }
                                $results['personal'][$j][$field] = $f;
                            }  
                     }
                     break;
                case 'permanent_address':
                    foreach($rs as $j=>$row){
                           unset($row['A']);
                            foreach($row as $i=>$f){
                                $field = $this->xls_fields[$tab][$fields[$i]];
                                $results['permanent'][$j][$field] = $f;
                            }  
                     }
                     break;
                case 'present_address':
                    foreach($rs as $j=>$row){
                           unset($row['A']);
                            foreach($row as $i=>$f){
                                $results['present'][$j][$this->xls_fields[$tab][$fields[$i]]] = $f;
                            }  
                     }
                     break;
                case 'father':
                    foreach($rs as $j=>$row){
                            unset($row['A']);
                            foreach($row as $i=>$f){
                                $results['father'][$j][$this->xls_fields[$tab][$fields[$i]]] = $f;
                            }  
                     }
                     break; 
                case 'mother':
                    foreach($rs as $j=>$row){
                            unset($row['A']);
                            foreach($row as $i=>$f){
                                $results['mother'][$j][$this->xls_fields[$tab][$fields[$i]]] = $f;
                            }  
                     }
                     break;    
                case 'local_guardian':
                    foreach($rs as $j=>$row){
                            unset($row['A']);
                            foreach($row as $i=>$f){
                                $results['guardian'][$j][$this->xls_fields[$tab][$fields[$i]]] = $f;
                            }  
                     }
                     break;  
                case 'admission':
                    foreach($rs as $j=>$row){
                            unset($row['A']);
                            foreach($row as $i=>$f){
                                $results['admission'][$j][$this->xls_fields[$tab][$fields[$i]]] = $f;
                            }  
                     }
                     break;       
                   
            }
               
        }
        return $results; 
        
    }
    
    protected function set_xls_fields(){
        if(!$this->xls_fields){
             $this->xls_fields =array(
            'personal'=> array('student_id'=>'student_id','first_name'=>'first_name','last_name'=>'last_name','dob'=>'dob','gender'=>'gender','caste'=>'caste_id',
                       'religion'=>'religion_id','nationality'=>'nationality_id','email'=>'email','mobile'=>'mobile','comments'=>'comments','is_tribe'=>'is_tribe'),
            'permanent_address'=> array('address'=>'address_line','post_code'=>'post_code'),
            'present_address'=> array('address'=>'address_line','same_as_permanent_address'=>'same', 'post_code'=>'post_code'),
            'father'=> array('first_name'=>'first_name','last_name'=>'last_name','mobile'=>'mobile','phone'=>'phone','email'=>'email','anual_income'=>'anual_income','occupation'=>'occupation_id','national_id'=>'national_id'),
            'mother'=> array('first_name'=>'first_name','last_name'=>'last_name','mobile'=>'mobile','phone'=>'phone','email'=>'email','anual_income'=>'anual_income','occupation'=>'occupation_id','national_id'=>'national_id'),
            'local_guardian'=> array('relationship'=>'relation','first_name'=>'first_name','last_name'=>'last_name','mobile'=>'mobile','phone'=>'phone','email'=>'email','anual_income'=>'anual_income','occupation'=>'occupation_id','national_id'=>'national_id'),
            'admission'=> array('class'=>'class_id','section'=>'section_id','session'=>'session','class_roll'=>'class_roll','fee'=>'fee','status'=>'status','comments'=>'comments'),
            );
        }
        
    }
    
	
	public function get_all_students($data='')
	{
		$this->db->select('s.id,s.extra_facility_id,student_number,p.first_name,last_name,gender,mobile,c.title class,sec.title section,a.class_roll,sp.file_name photo');
        $this->db->from('student s');
        $this->db->join('personal_details p', 'p.id = s.personal_details_id', 'left');
		$this->db->join('student_photo sp', 'sp.id = s.photo_id', 'left');
		$this->db->join('admission a', 'a.student_id = s.id', 'left');                
        $this->db->join('class c', 'c.id = a.class_id', 'left');
		$this->db->join('section sec', 'sec.id = a.section_id', 'left');
		$this->db->where('a.class_id',$data['class_id']);
		if($data['section_id']>0){
		$this->db->where('a.section_id',$data['section_id']);   
		}		
		$this->db->order_by('a.class_roll','ASC');
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
    public function get_all_students_data($data=''){
        $this->db->select('s.id,s.extra_facility_id,student_number,p.first_name,last_name,gender,mobile,c.title class,sec.title section,a.class_roll,sp.file_name photo');
        $this->db->from('student s');
        $this->db->join('personal_details p', 'p.id = s.personal_details_id', 'left');
        $this->db->join('student_photo sp', 'sp.id = s.photo_id', 'left');
        $this->db->join('admission a', 'a.student_id = s.id', 'left');
        $this->db->join('class c', 'c.id = a.class_id', 'left');
        $this->db->join('section sec', 'sec.id = a.section_id', 'left');
        $this->db->where('a.class_id', $data['class_id']);
        $this->db->where('s.status_id', '1');
        if ($data['section_id'] > 0) {
            $this->db->where('a.section_id', $data['section_id']);
        }
        $this->db->order_by('a.class_roll', 'ASC');
        $query = $this->db->get();
        $rs = $query->result();
        return $rs;
    }
	
	public function update_extra_facility($data)
	{
		@$this->db->update_batch('student',$data,'id'); 
	}
	
	public function re_update_extra_facility($data)
	{
		@$this->db->update_batch('student',$data,'id'); 
	}
	
	
	public function count_student_classwise()
	{
		$this->db->select('s.id,COUNT(s.id) as total_student,c.title class_name');
        $this->db->from('student s');
		$this->db->where('s.status_id',1);
        $this->db->join('admission a', 'a.student_id = s.id', 'left');                
        $this->db->join('class c', 'c.id = a.class_id', 'left');
		//$this->db->join('section sec', 'sec.id = a.section_id', 'left');
		$this->db->group_by('a.class_id');
		$this->db->order_by('c.serial','asc');	
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
	
	
	public function update_student_class($student_id,$data)
	{
		$this->db->update('admission',$data,array('student_id'=>$student_id));
	}
		
	public function allstudent()
	{
		$this->db->select('id,student_number');
        $this->db->from('student');        		
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}
	
	public function update_student_number($student_id,$data)
	{
		$this->db->update('student',$data,array('id'=>$student_id));
	}
	
   public function update_student_approve($id,$data)
   {
		$this->db->update('student', $data, array('id' => $id)); 
       return 1;
   }
   
   public function get_approve($id)
	{
		$this->db->select('s.is_approve');
        $this->db->from('student s');
        $this->db->where('s.id',$id);
		$query = $this->db->get();
			foreach($query->result() as $val){
 			$is_approve = $data['is_approve'] = $val->is_approve;
		}
		
		return $is_approve;
	}
    function get_student_data($class_id, $section_id) {
        $this->db->select('sv.*, ad.address_line, po.name post_office, th.name thana, ds.name district');
        $this->db->from('student_v sv');
        $this->db->join('address ad', 'ad.id = sv.present_address_id', 'left');
        $this->db->join('district ds', 'ds.id = ad.district', 'left');
        $this->db->join('thana th', 'th.id = ad.thana', 'left');
        $this->db->join('post_office po', 'po.id = ad.post_office_id', 'left');
        $this->db->where('class_id', $class_id);
        $this->db->where('sv.status', 'Active');
        if(isset($section_id) && $section_id > 0){
            $this->db->where('section_id', $section_id);
        }
		$this->db->order_by('sv.class_roll','asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
	
	public function get_roll($student_id)
	{
		$this->db->select('student_id,position');
        $this->db->from('result_sheet');
		$this->db->where('student_id',$student_id);	
		$this->db->where('exam_id',20 );	
		$this->db->or_where('exam_id',21);	
		$this->db->group_by('student_id');
		$query = $this->db->get();
		$rs = $query->row_array();
		return $rs;
	}
}

?>