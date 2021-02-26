<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Comment extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		 $this->init_grid();

	}
   
    protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Comment list');
	   $actions = array(
						//'view'=>array('title'=>'View','action'=>'view','controller'=>'','tips'=>'View details'),
						'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Reply'),
						'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete'),
						);
	   $this->grid_board->set_action($actions);
       //$this->grid_board->add_link('Make Reply',site_url('comment/reply'),array('class'=>'add'));
	   $grid_columns = array('id'=>array('visible'=>false),'comment'=>'Comment','comment_date'=>'Comment Date','reply'=>'Reply','reply_date'=>'Reply Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('comment_model');
	}
    public function reply(){
            $this->load->form('comment_form','cform');
        }
    public function save(){
            $this->load->form('comment_form','cform');
            $this->process_cform($this->cform);
            $this->tpl->set_view('reply');
        }
	protected function process_cform($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
				$this->session->set_flashdata('success',"Reply has been created successfully");
			else
				$this->comment_model->update(array('replyer_id'=>$this->auth->get_user()->id,'id'=>$form->get_value('id')));
				$this->session->set_flashdata('success',"Reply  has been successfully submitted");
		    redirect('comment');
		}
	}
        
    function edit($id='')
	{	
		if(empty($id))
        redirect('comment');
		$this->load->model('comment_model','clmodel');
		$info = $this->clmodel->find($id);
		$this->load->form('comment_form','cform',$info);
        $this->tpl->set_view('reply');
	}
        
    /*public function view($id){
            $this->load->model('comment_model','clmodel');
	    $info = $this->clmodel->find($id);
            if(empty($info))
            {
                    show_404();
            }
           $labels = array('comment'=>'Comment','comment_date'=>'Commente on','reply'=>'Reply');
           $this->tpl->assign('labels',$labels);
           $this->tpl->assign('row',$info); 
           $this->tpl->set_view('elements/record_view.php',true);
        }*/
    public function del($id)
	{
		$this->load->model('comment_model','clmodel');
		$this->clmodel->delete($id);
		$this->session->set_flashdata('success',"Comment has been deleted successfully");
		redirect('comment');
	}
	
	
      
        
	
	
}