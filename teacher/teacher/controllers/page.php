<?php
/*
 * Created on Mar 18, 2010
 * 
 * Created By ARENA MOBILE DEVELOPMENT TEAM (@ Reza Ahmed)
 * 
 */
 
 class Page extends Bindu_Controller
 {
 	var $breadcrumb=array();
 	function __construct()
 	{
 		parent::__construct();
 		
 		$this->load->model(array('pagemodel','menumodel'));
 	}
  	
 	function view($id='')
 	{
 		
		if(empty($id))
 		{
 			redirect('home');
 		}
 		
		// get submenu 
		$row=$this->menumodel->get_parent_id($id);       // get parent id
		$parent_id=$row['parent_id'];
		
		$parent_menu=$this->menumodel->get_parent_menu($parent_id);   // get parent menu
		$this->assign('parent_menu',$parent_menu);
		
		foreach($parent_menu as $menu)
		{
		if($menu['id']==$id){				
				$sub_menu=$this->menumodel->get_sub_menu($id);
				$this->assign('sub_menu',$sub_menu);
			}
		}
		
		$this->assign('id',$id);
		
		
		// end submenu
		$this->set_breadcrumb($id);
		
		$content_id=$this->menumodel->get_menu_content_id($id);
		$this->assign('pid',$id);
      	
		if($content_id)
 		{
 			$content=$this->pagemodel->get_record($content_id);
 			$this->assign('static_content',$content);
 			$this->tpl->set_page_title($content['title']);
			$this->tpl->set_page_description($content['description']);
 			if(!empty($content)){
				$this->load->view('page/page_container');
			}
			else
			{
				$this->load->view('page/blank');
			}
			///------------------------------------------//		
		}
		else
		{
			$this->load->view('page/blank');
		} 			
 			
	}
	
 	
 	function content($cid)
 	{
 		if(empty($cid))
 		{
 			redirect('home');
 		}
	   $mid=$this->pagemodel->get_menu_item($cid);
	   $this->view($mid);
 	}
 	
	/**------------------- start contact us --------------------**/
	
	function contact()
  	{  		
  		$this->tpl->set_page_title("Contact Us");	  
		$this->load->library(array('form_validation'));
  		$config = array(
				array(
                     'field'   => 'name',
                     'label'   => 'Name',
                     'rules'   => 'trim|required|xss_clean'
                    ),					
				array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|valid_emails'
                    ),
				array(
                     'field'   => 'contact',
                     'label'   => 'contact',
                     'rules'   => 'trim|xss_clean'
                    ),	
				array(
                     'field'   => 'subject',
                     'label'   => 'Subject',
                     'rules'   => 'trim|required|xss_clean'
                    ),
				array(
                     'field'   => 'message',
                     'label'   => 'Message',
                     'rules'   => 'trim|required|xss_clean'
                    )						
                );
	  	$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="verr">', '</span>');
	  	
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('page/contact_us');						
		}
		else
		{	
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			$contact_no=$this->input->post('contact_no');
			$subject=$this->input->post('subject');
			$message=$this->input->post('message');
			
			$fullmessage='
			<table>
				<tr>           
					<td>Name :</td>
					<td>'.$name.'</td>
				</tr>
				<tr>           
					<td>E-mail :</td>
					<td>'.$email.'</td>
				</tr>
				<tr>           
					<td>Contact No. :</td>
					<td>'.$contact_no.'</td>
				</tr>
				<tr>           
					<td>Subject :</td>
					<td>'.$subject.'</td>
				</tr>
				<tr>           
					<td>Message :</td>
					<td>'.$message.'</td>
				</tr>	
			</table>';
		
			$to='rifat.pstu@gmail.com';   // put default email
			
			$subject = 'Contact Form Query';
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= 'From: sapien@gmail.com' . "\r\n".
			'X-Mailer: PHP/' . phpversion();
			$mail=mail($to, $subject, $fullmessage, $headers);
			
			if($mail){
				$this->session->set_flashdata('message',"<div class='info'>Your message has been sent successfully.</div>");	
				redirect('page/contact');
			}else{
				$this->session->set_flashdata('message',"<div class='error'>Your message not sent.</div>");	
				$this->load->view('page/contact_us');
			}			
		}  	
  	}
	
 	/**------------------- end contact us --------------------**/
	
	
	function contact_form()
	{
		$name=mysql_real_escape_string($_POST['name']);
		$email=mysql_real_escape_string($_POST['email']);
		$contact_no=mysql_real_escape_string($_POST['contact_no']);
		$subject=mysql_real_escape_string($_POST['subject']);
		$message=mysql_real_escape_string($_POST['msg']);
		
		$fullmessage='
		<table>
			<tr>           
				<td>Name :</td>
				<td>'.$name.'</td>
			</tr>
			<tr>           
				<td>E-mail :</td>
				<td>'.$email.'</td>
			</tr>
			<tr>           
				<td>Contact No. :</td>
				<td>'.$contact_no.'</td>
			</tr>
			<tr>           
				<td>Subject :</td>
				<td>'.$subject.'</td>
			</tr>
			<tr>           
				<td>Message :</td>
				<td>'.$message.'</td>
			</tr>	
		</table>';
	
		$to='rifat.pstu@gmail.com';   // put default email
		
		$subject = 'Contact Form Query';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: sapien@gmail.com' . "\r\n".
		'X-Mailer: PHP/' . phpversion();
		$mail=mail($to, $subject, $fullmessage, $headers);
		
		if($mail){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	
	function who_are_devels()
	{
		$this->devel_mems();
	}
 	
 	/*
	*@Counselling filter.
	*@Created By mukul. 	
	*@Date 27.10.2013
	*/
	/*--------------- Start counselling filter ------------------*/
	
	function counselling_filter()
	{
	
		echo "<script language='javascript' type='text/javascript'>
		$(document).ready(function() {
		   $('.toggle').click(function () {
			if ($(this).next().is(':hidden')) {
					$(this).next().slideDown('slow'); // slide it down
				} else {
					$(this).next().hide('slow'); // hide it
				}
			});
		});
		</script>
		<style type='text/css'> 
		.hiddenDiv{
		display:none;
		}
		</style>";
		$category_id=trim($_POST['category_id']);
		if($category_id==0)
		{ 
			
			$counselling_filter=$this->seekermodel->get_counselling_all();			
		}
		else
		{
			$counselling_filter=$this->seekermodel->counselling_by_filter($category_id);			
		}
		foreach ($counselling_filter as $filter )
			{
				echo "<span class='toggle'>";
				echo	"<b>Question : </b>";
				echo " <span style='cursor:pointer;'>";     
				echo $filter['question'];
				echo "</span>";
				echo "</span>";
				echo "<div class='hiddenDiv'>";
			   
			   if($filter['show_status']==1)
			   {
					echo "<b>By:</b>";
					echo $filter['username'];
					echo " ";
					echo "< "; echo $filter['email']; echo " >";
					echo "</br>";
				}
				if($filter['show_status']==2)
			   {
					echo "<b>By:</b>";
					echo $filter['username'];
					echo "</br>";
				}
				if($filter['show_status']==3)
			   {
					echo "<b>By:</b>";
					echo " ";
					echo "< "; echo $filter['email']; echo " >";
					echo "</br>";
				}
				if($filter['show_status']==4)
			   {
					
			   }
				
				echo "<b>Answer:</b>";
				echo $filter['answer'];
				echo "</div>";
				echo "</br>";
			}
	}
	
	
	
	
	/*--------------- End counselling filter ------------------*/

	/*
	*@Counselling View.
	*@Created By mukul. 	
	*@Date 24.10.2013
	*/
	/*--------------- Start Counselling View ------------------*/
	
     function counselling_view()
	{
		//$seeker_id=$this->seeker_id;
		$category_list=$this->seekermodel->get_category();
		$this->assign('category_list',$category_list);
		$counselling_list = $this->seekermodel->get_counselling_all();
		$this->assign('counselling_list',$counselling_list);
		$this->load->view('page/counselling_view');
	}
	
	/*--------------- End Counselling View ------------------*/
	
 }
?>
