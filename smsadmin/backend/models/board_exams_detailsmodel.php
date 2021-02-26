<?php

/* 
 * @ Author         Avijit Chakravarty
 * 
 * @ Created        29th January, 2017
 */

class Board_exams_detailsmodel extends BACKEND_Model {
    function __construct() {
        parent::__construct();
    }
    function get_table_name() {
        return 'board_exams_details';
    }
    function get_columns() {
        return array('id', 'board_exam_id', 'description', 'year', 'file_name', 'status', 'created_on', 'created_by');
    }
    function grid_query(){
        $this->info_query();
    }
    function info_query(){
        $query = $this->db->select('bed.*, bx.title board_exam_name')
                ->from('board-exams_details bed')
                ->join('board_exams bx', 'bx.id = bed.board_exam_id', 'left');
        return $query;
    }
    public function get_info($id)
    {
        $query = $this->get_info_query();
        $query->where('id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function update_board_exams($data, $id){
        $this->db->update('board_exams_details', $data, array('id' => $id));
    }
    function get_board_exams(){
        $this->db->select('bed.*, bx.title exam_name');
        $this->db->from('board_exams_details bed');
        $this->db->join('board_exams bx', 'bx.id = bed.board_exam_id', 'left');
        $this->db->order_by('bed.year', 'desc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    function delete($id){
        $this->db->delete('board_exams_details', array('id' => $id));
    }
}