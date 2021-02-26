<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gamil.com>
 * @ Created     September 01, 2012
 */
class Noticeboardmodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_columns() {
        return array('id','notice_title','full_notice','version_id','class_id','section_id','house_id','facility_id','student_number','designation_id','status','created_at');
    }

    public function get_table_name() {
        return 'notice_board';
    }

    public function grid_query() {
        $query = $this->db->select('nb.id,nb.student_number,nb.status,notice_title,full_notice,nb.created_at,ver.title version,cl.title class_name,sec.title section,h.title house,ef.title facility,dg.title designation', False)
                ->from('notice_board nb')
				->join('version_list ver', 'ver.id=nb.version_id', 'left')
                ->join('class cl', 'cl.id=nb.class_id', 'left')
				->join('section sec', 'sec.id=nb.section_id', 'left')
				->join('designation dg', 'dg.id=nb.designation_id', 'left')
				->join('house h', 'h.id=nb.house_id', 'left')
				->join('student_extra_facility_list ef', 'ef.id=nb.facility_id', 'left');
    }

}

?>