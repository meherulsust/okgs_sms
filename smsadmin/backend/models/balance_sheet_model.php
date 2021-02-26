<?php

class Balance_sheet_model extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'balance_sheet';
    }

    public function get_columns() {
        return array('id','balance_type','balance_title_id','ammount','year','month','created_by','date','date');
    }
	
    public function grid_query() {
        $this->db->select('bs.id,ammount,YEAR(date) as year,MONTHNAME(STR_TO_DATE(MONTH(date), "%m")) as month,bs.date,bs.date,bst.title,bs.balance_type',false)
                ->from('balance_sheet bs')
				->join('balance_sheet_title bst', 'bst.id = bs.balance_title_id', 'left')
				->order_by('bst.title','ASC');
    }
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('balance_sheet bs');
        return $query->count_all_results();
    }
	
    public function get_details_info($id) {
        $this->db->select('bs.id,ammount,YEAR(date) as year,MONTH(date) as month,bs.date,bst.title,bs.balance_type',false)
                ->from('balance_sheet bs')
				->join('balance_sheet_title bst', 'bst.id = bs.balance_title_id', 'left')     
                ->where('t.id', $id);
        $query = $this->db->get();
        return $query->row_array();
        
    }
	
    public function get_all_report($sdata){
        $this->db->select('bs.id,ammount,YEAR(date) as year,MONTHNAME(STR_TO_DATE(MONTH(date), "%m")) as month,bs.date,bst.title,bs.balance_type', false);
        $this->db->from('balance_sheet bs');
        $this->db->join('balance_sheet_title bst', 'bst.id = bs.balance_title_id', 'left');
        $this->db->where('YEAR(bs.date)', $sdata['year']);
        if (($sdata['month']) != '') {
            $this->db->where('MONTH(bs.date)', $sdata['month']);
        }
        if (($sdata['day_from']) != '' AND ( $sdata['day_to']) != '') {
            $this->db->where('DATE(bs.date) >=', $sdata['day_from']);
            $this->db->where('DATE(bs.date) <=', $sdata['day_to']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
	public function get_total($sdata){
		$this->db->select('SUM(ammount) total',false);
		$this->db->from('balance_sheet');
		$this->db->where('YEAR(date)', $sdata['year']);
		$this->db->where('balance_type','Income');
			if(($sdata['month'])!=''){
				$this->db->where('MONTH(date)', $sdata['month']);	
			}
			if(($sdata['day_from'])!='' AND ($sdata['day_to'])!='' ){
				$this->db->where('DATE(date) >=', $sdata['day_from']);
				$this->db->where('DATE(date) <=', $sdata['day_to']);	
			}
		$query = $this->db->get();
        return $query->row_array();		
	}
	public function get_cost($sdata){
		$this->db->select('SUM(ammount) cost',false);
		$this->db->from('balance_sheet');
		$this->db->where('balance_type','Expenditure');
		$this->db->where('YEAR(date)', $sdata['year']);
			if(($sdata['month'])!=''){
				$this->db->where('MONTH(date)', $sdata['month']);	
			}
			if(($sdata['day_from'])!='' AND ($sdata['day_to'])!='' ){
				$this->db->where('DATE(date) >=', $sdata['day_from']);
				$this->db->where('DATE(date) <=', $sdata['day_to']);	
			}
		$query = $this->db->get();
        return $query->row_array();	
	}

    public function get_collection($sdata){
        $this->db->select('SUM(ammount) collection, YEAR(payment_date) as year, MONTHNAME(STR_TO_DATE(MONTH(payment_date), "%m")) as month, COUNT(*) rows_total', FALSE);
        $this->db->from('student_tuition_fee_payment');
        $this->db->where('pay_status', 'PAID');
        $this->db->where('YEAR(payment_date)', $sdata['year']);
        if(($sdata['month'])!=''){
            $this->db->where('MONTH(payment_date)', $sdata['month']);	
        }
        if(($sdata['day_from'])!='' AND ($sdata['day_to'])!='' ){
            $this->db->where('DATE(payment_date) >=', $sdata['day_from']);
            $this->db->where('DATE(payment_date) <=', $sdata['day_to']);	
        }
        $rs = $this->db->get();
        return $rs->row_array();
    }
}
?>