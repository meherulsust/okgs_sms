<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Created By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    November 01, 2015
 */
 ini_set('display_errors', 0);
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
 class Bulk_sms extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->filter('bulk_message_filter', 'bmf');
		$this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'bulk_sms'));
		$this->init_grid();		
	}
   
    protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_filter($this->bmf);
	   $this->grid_board->set_title('Bulk SMS List');
	   $actions = array(
						'view'=>array('title'=>'View','action'=>'view','controller'=>'','tips'=>'View SMS details'),
						'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete SMS'),
						);
	   $this->grid_board->set_action($actions);
       $this->grid_board->add_link('New Bulk SMS',site_url('bulk_sms/create'),array('class'=>'add'));
	   $grid_columns = array('id'=>array('visible'=>false),'message'=>'Message','mobile'=>'Mobile No','date'=>'Created','status'=>'Status');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('bulk_sms_model');
	}
	
	
    public function filter() {
        $this->load->filter('bulk_message_filter', 'bmf');
        $this->bmf->execute();
        redirect('bulk_sms');
    }
	
    public function create() {
        $this->load->form('bulk_smsform', 'bsform');
    }
    public function save(){
		$this->load->form('bulk_smsform','bsform');
		$this->process_form($this->bsform);
		$this->tpl->set_view('create');
	}
  
    public function view($id){
		$this->load->model('bulk_sms_model','usmodel');
		$info = $this->usmodel->find($id);
		if(empty($info))
		{
				show_404();
		}
	   $labels = array('message'=>'Message','mobile'=>'Mobile');
	   $this->tpl->assign('labels',$labels);
	   $this->tpl->assign('row',$info); 
	   $this->tpl->set_view('elements/record_view.php',true);
	}
    public function del($id)
	{
		$this->load->model('bulk_sms_model','bsmodel');
		$this->bsmodel->delete($id);
		$this->session->set_flashdata('success',"SMS been deleted successfully");
		redirect('bulk_sms');
	}
	
	
	protected function process_form($form) {
        $this->load->library('Spreadsheet_Excel_Reader');
		$this->load->form('bulk_smsform','bsform');
        $this->load->model('bulk_sms_model');
        if ($form->validate()) {
            
			if ($form->is_new()){
				
				if(trim($_FILES["bulk_sms_mobile"]["name"])!='')
				{
					$ext = end(explode(".", $_FILES['bulk_sms_mobile']['name']));
					$file_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;
					$bulk_path = $this->config->item('upload_dir').'bulk_sms/';
					$file = $bulk_path.$file_name; 
					$config['upload_path'] = $bulk_path ;
					$file_info = pathinfo($file_name);
					$config['file_name']=basename($file_name,'.'.$file_info['extension']);
					$config['allowed_types'] = 'xls';
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('bulk_sms_mobile')) {
						$this->session->set_flashdata('success', "Bulk SMS has been uploaded successfully.");
						$data = new Spreadsheet_Excel_Reader($file);
					    for ($x =1; $x <= count($data->sheets[0]["cells"]); $x++) {
						$mobile['message'] = $this->input->post('bulk_sms_message');
						$mobile['mobile'] = $data->sheets[0]["cells"][$x][1];
						if($mobile['mobile']=='' OR $mobile['mobile']=='0')						
						break;							
						
						/* $sms_id=rand(100000,999999);
						$gsm='880'.substr($mobile['mobile'],-10);
						$message=urlencode($mobile['message']);
						$username='arerajcpsc';
						$password='arerajcpsc!@#';
						$security_code='arenaapi!@#';
						$url = 'http://202.126.120.118/smsenquiry/index.php/home'; */
									
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec ($ch);
						curl_close ($ch); 	
						
						
						$mobile['status']=1;			
						 
						$this->bulk_sms_model->save_bulk_data($mobile);						
						
					   }
						unlink($file);
						redirect('bulk_sms/index');

					}else{
						$this->session->set_flashdata('error',$this->upload->display_errors());
						redirect('bulk_sms/create');
					}  
				}
			}	
		}
	}
	
}