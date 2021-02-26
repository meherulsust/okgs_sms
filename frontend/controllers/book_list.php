<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Book_list extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
    }

  	function index()
	{		
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$book_list = $this->studentvmodel->get_book_list($row['class_id']);
		$this->tpl->assign('book_list',$book_list);		
	}	
	
	public function download()
	{
		$this->tpl->set_layout(false);	
		$this->load->library('pdf');
		$this->load->helper('date');
		
		$this->load->model('studentvmodel');
		$this->load->model('schoolmodel');
		$school_info = $this->schoolmodel->find(1);
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$book_list = $this->studentvmodel->get_book_list($row['class_id']);
		
		$html = '<style type="text/css">
		.book_list{
			border-collapse:collapse;
		}
		.book_list tr{
			border:1px solid #ddd;
		}
		.book_list tr td{
			font-size:12px;
			border:1px solid #ddd;
			padding:2px 4px;
		}
		</style>';	

		$html .='<h4 align="center">'.strtoupper($school_info['name']).'</h4>
			<h6 align="center">'.strtoupper($school_info['address1']).'<br>'.strtoupper($school_info['address2']).'</h6>
			<h4 align="center">Book List</h4>';

		$html .='<table width="80%" align="center" class="book_list" border="0">					
					<tr>
						<td width="20%">Class :</td>
						<td>'.$row["class"].'</td>						
					</tr>
					<tr>						
						<td width="20%">Form :</td>
						<td>'.$row["section"].'</td>
					</tr>
				</table><br>';	
		
		$html .='<table width="80%" align="center" class="book_list">		
				<tr>
					<td width="5%" align="center"><b>SL. No.</b></td>
					<td width="60%" align="center"><b>Book Name</b></td>
					<td width="25%" align="center"><b>Writer Name</b></td>
					<td width="25%" align="center"><b>Book Link</b></td>
				</tr>';
		if(!empty($book_list)):
		$i=1;
		foreach($book_list as $val):		
		$html .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.$val['title'].'</td>
					<td>'.$val['writer_name'].'</td>
					<td>'.$val['link'].'</td>
				</tr>';
			$i++;
		endforeach;		
		else: 
		$html .='<tr>
				<td align="center" colspan="3">No book is found.</td>		
			</tr>';
        endif;
		
		$html .='</table>';		
		
		$full_html=	$html;
		$pdf = $this->pdf->load();
		$pdf->WriteHTML($full_html); // write the HTML into the PDF
		$pdf->Output('Book_list_'.date(DATE_FORMAT).'.pdf','D');
		exit;
		
		
	}
	
	function notebook()
	{		
		
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$data['class_id'] = $row['class_id'];
		$data['section_id'] = $row['section_id'];
		$notebook_list = $this->studentvmodel->get_notebook($data);
		$this->tpl->assign('notebook_list',$notebook_list);	
	}
	
	public function note_download($file_name)
	{
		$this->load->helper('download');
		$data = file_get_contents(base_url()."smsadmin/uploads/note_book/".$file_name); 
		$name = $file_name;
		force_download($name,$data);
	}
	
	public function note_view($file_name)
	{
		$this->tpl->set_layout(false);
		$this->tpl->assign('file_name',$file_name);	
		
	}
	
 }