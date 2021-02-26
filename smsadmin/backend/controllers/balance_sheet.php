<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Md.Meherul Islam
 * @ Created     18.10.2016
 */
class Balance_sheet extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->init_grid();
    }
	
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Balance sheet list');
        $grid_columns = array('id' => array('visible' => false),
            'title'=>'Title','balance_type'=>'Balance Type','month'=>'Month','year'=>'Year','ammount'=>'Amount','date'=>'Create Date');
        $this->grid_board->set_column($grid_columns);
		$actions = array(            
            //'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete record'),
			'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit record'),
        );
        $this->grid_board->set_action($actions);
		
        $this->grid_board->render('balance_sheet_model');
    }
	
    function create() {
        $this->load->form('balance_sheetform', 'bsform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
    }
	
	function save() {
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $this->load->form('balance_sheetform', 'bsform');
        $this->process_form($this->bsform);
        $this->tpl->set_view('create');
    }
	
    public function edit($id) {
		$this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $this->load->model('balance_sheet_model');
        $info = $this->balance_sheet_model->find($id);
        if(empty($info)){
            show_404();
        }
		$this->load->form('balance_sheetform', 'bsform',$info);
		$this->process_form($this->bsform);        
    }
	
	
   
    protected function process_form($form) {
        if ($form->validate()) {            
			$id = $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Balance sheet has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Balance sheet has been edited successfully");
            }
            redirect('balance_sheet');
        }
    }

    public function del($id) {
        $this->load->model('balance_sheet_model');        
		$this->balance_sheet_model->delete($id);
		$this->session->set_flashdata('success', "Balance has been deleted successfully.");
		redirect('balance_sheet');       
    }
	
	/*--------------------  End report ---------------------*/
	function report() {        
        
		$this->load->form('balancereportform', 'bform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker'));
	}
	
    function report_download() {

        $this->tpl->set_layout('ajax_layout');

        /* ----------------- get search value ------------- */
        $sdata['year'] = $this->input->post('report_year');
        $sdata['month'] = $this->input->post('report_month');
        $sdata['day_from'] = $this->input->post('report_day_from');
        $sdata['day_to'] = $this->input->post('report_day_to');
        $this->tpl->assign('sdata', $sdata);
        /* ----------------- End search value ------------- */
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $this->tpl->assign('school_info', $school_info);
        $this->load->model('balance_sheet_model');        
        $cost = $this->balance_sheet_model->get_cost($sdata);
        $this->tpl->assign('cost', $cost);
        $report = $this->balance_sheet_model->get_all_report($sdata);
        $total = $this->balance_sheet_model->get_total($sdata);
        
        $collection = $this->balance_sheet_model->get_collection($sdata);

//        $total_service_charge = $collection['rows_total'] * 13.80;
//        $collection_amount = $collection['collection'] - $total_service_charge;
        $collection_amount = $collection['collection'];
        
        $collection_data = array();
        if($collection['collection'] > 0){
            $collection_data = array(   
                array(
                    'ammount' => $collection_amount,
                    'year' => $collection['year'],
                    'month' => $collection['month'],
                    'title' => 'Payment Collection',
                    'balance_type' => 'Income',
                    'date'  => ''
                )
            );
        }
        $report = array_merge($report, $collection_data);
        $total = $total['total'] + $collection_amount;
        $this->tpl->assign('total', $total);

        if (!empty($report)) {
            $this->tpl->assign('report', $report);

            /* --------- generate search head ----------- */

            if ($sdata['year'] == '') {
                $year = ', Year : All';
            } else {
                $year = ', Year : ' . $sdata['year'];
            }
            if ($sdata['month'] == '') {
                $month = ', Month : All';
            } else {
                $month = ', Month : ' . $sdata['month'];
            }

            if ($sdata['day_from'] != '' AND $sdata['day_to'] == '') {
                $date = $year . $month . ', Day :' . $sdata['day_from'];
            } else if ($sdata['day_from'] == '' AND $sdata['day_to'] != '') {
                $date = $year . $month . ', Day :' . $sdata['day_to'];
            } else {
                $date = $year . $month . ', Day : All';
            }

            $report_title = 'Report for : ' . $date;
            $this->tpl->assign('report_title', $report_title);
            $report_file_name = 'Balance_sheet_report_for_' . date('y-m-d') . '.xls';
            $this->tpl->assign('report_file_name', $report_file_name);
            /* --------- end generate search head ----------- */
        } else {
            $this->session->set_flashdata('info', "No data available.");
            redirect('balance_sheet/report');
        }
    }
	
	/*--------------------  End report ---------------------*/

}

?>
