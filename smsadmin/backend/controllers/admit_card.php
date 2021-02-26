<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admit_card extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->tpl->set_jquery_ui();
        $this->tpl->set_js('select-chain');
		$this->load->form('admit_card_form','adcform');
		if($this->adcform->validate())
		{
			$this->load->library('pdf');
			$this->tpl->set_layout('ajax_layout');
			//$this->tpl->set_css('idcard');
			$this->load->model('studentmodel');
			$this->load->model('schoolmodel');
			$this->load->model('classmodel');
			$school_info = $this->schoolmodel->find(1);	  // get school info
			$this->tpl->assign('school_info',$school_info);
			
			$data['class_id']=$this->input->post('admitcard_class_id');
			$data['section_id']=$this->input->post('admitcard_section_id');
			$data['description']=$this->input->post('admitcard_description');
			$class_info = $this->classmodel->find($data['class_id']);	  // get class info
			$std_info = $this->studentmodel->get_all_students_data($data);		// get student info
			$this->tpl->assign('student_info',$std_info);
			
			if(!empty($std_info))
			{
			$html='<link rel="stylesheet" href="'.base_url().'css/admit_card.css" type="text/css" media="screen,print" />';			
			
			$i=1;
			foreach($std_info as $val){	
			$html .='<div id="card11">
					<table align="center" border="0" style="margin:0 10px 20px 0;width:550px;background:#F0FCFA;padding:5px;border-radius:4px;border:2px solid #000;" cellspacing="0" cellpadding="1">
						<tr>
							<td colspan="3" align="center">
								<div class="title">'.strtoupper($school_info['name']).'</div> 
							</td>
						</tr> 		
						<tr>
							<td align="center" width="25%" valign="top">
								<img class="image" src="'.base_url().'uploads/logo/'.$school_info['logo_file'].'"/>
							</td>
							<td align="center" width="50%" valign="top">
								<br/>
								<div class="title">ADMIT CARD</div>						
							</td>
							<td align="left" width="25%" valign="bottom" style="padding-bottom:12px;">';
							if($val->photo!=''){
							$html .='<img class="image" height="70" src="'.base_url().'uploads/std_photo/'.$val->photo.'"/>';
							}
							$html .='<span class="address">Roll No. : '.$val->class_roll.'</span>	<br>
								<span class="address">ID No: '.$val->student_number.'</span>
							</td>
						</tr>
						
						<tr>
							<td width="25%" align="right" valign="middle">
								<div class="name">Name :</div>
								<div class="class">Class :</div>
								<div class="class">Form :</div>
							</td>
							<td width="75%" colspan="2" valign="middle">				
								<div class="name">'.ucwords(strtolower($val->first_name. ' '.$val->last_name)).'</div>	
								<div class="class">'.$val->class.'</div>	
								<div class="class">'.$val->section.'</div>
							</td>			
						</tr>
						<tr>
							<td colspan="3" align="center">
								<div class="admit_description" style="font-size:15px; font-weight: bold; text-decoration: underline;">'.$data['description'].'</div>				
							</td>						
						</tr>		
						<tr>				
							<td align="center" width="25%" valign="bottom">				
								<p><img class="image" style="bottom:0;" src="'.base_url().'img/account_officer.png"/></p>
							</td>
							<td align="center" width="50%" valign="bottom">				
								<p><!-- <img class="image" style="bottom:0;" src="'.base_url().'img/exam_president.png"/></p> -->
							</td>
							<td align="center" width="25%" valign="bottom">				
								<p><img class="image" style="bottom:0;" src="'.base_url().'img/principal.png"/></p>
							</td>
						</tr>	
						<tr>				
							<td align="center" valign="top">			
								<span class="name" style="border-top:1px solid #000;">Head Accountant</span>
							</td>
							<td align="center" valign="top">			
								<!--<span class="name" style="border-top:1px solid #000;padding:0 10px;">Convener Exam Committee</span> -->
							</td>
							<td align="center" valign="top">			
								<span class="name" style="border-top:1px solid #000;">Headmaster</span>
							</td>
						</tr>	
					</table>
				</div>';
			if($i%3==0)	
			$html .= '<div style="page-break-after:always"></div>';
			$i++;
			}
			
			//$this->tpl->set_view('generate_admit_card');
			
			$full_html=	$html;
//			echo $full_html;
//                        exit();
			$pdf = $this->pdf->load();
			$pdf->WriteHTML($full_html); // write the HTML into the PDF
			$pdf->Output('Admit_card_'.$class_info['title'].'.pdf','D');
			//$this->session->set_flashdata('success',"Admit Card has been generated successfully.");
		    //redirect('admit_card/index');	
			}else{
				$this->session->set_flashdata('error',"No data available.");
				redirect('admit_card/index');	
			}
			
		}else{
			$this->tpl->set_view('index');
		}		
	}
	
	
	
}