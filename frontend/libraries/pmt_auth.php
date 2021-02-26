<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Feb 23, 2012
 */
class Pmt_auth {

    protected $CI;
    private $_user = null;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        $this->CI->load->config('pmt_auth');
        $this->CI->load->library('pmt_auth_user');
    }

    /**
     * returns true or false by selecting 
     * user based on provided credential
     * @param array $credential
     * @return boolean 
     */
    public function check_login(array $credential) {
         $query = $this->_prepare_query();
        if ($query) {
             $fields = $this->CI->config->item('credential_fields');
             foreach ($fields as $fld) {
                $org_field  = end(explode('.', $fld));
                if (!array_key_exists($org_field, $credential)) {
                    return false;
                }
                $query->where($fld, $credential[$org_field]);
            }
             $query = $query->get();
            if ($query->num_rows() == 1) {
                $rows = $query->result('Pmt_auth_user');
                $this->_user =$rows[0];
                $session_vars =  $fields = $this->CI->config->item('auth_session_vars');
                foreach($session_vars as $var=>$column){
                       $user_data[$var] = $this->_user->{$column};
                }
                $user_data['logged_in'] = true;
                $this->CI->session->set_userdata($user_data);
                return true;
            } else {
                return false;
            }
        }else{
            show_error('Auth: Please specify auth table name in auth configuration.');
        }
    }
    
    private function _prepare_query(){
        $tbl = $this->CI->config->item('auth_table');
        if($tbl){
            $query = $this->CI->db->select($this->CI->config->item('auth_display_fields'),false)
                    ->from($tbl);
            $gtbl = $this->CI->config->item('auth_group_table');
            $rel = $this->CI->config->item('auth_goup_relation');
            if( $gtbl && $rel ){
                 $query->join($gtbl,$rel,'left');
            }
            return $query;
        }
        return false;
    }

    public function is_logged_in() {
         $session_vars =  $fields = $this->CI->config->item('auth_session_vars');
         $is_authentic = true;
         foreach($session_vars as $var=>$column){
                     if(!$this->CI->session->userdata($var)){
                         $is_authentic = false;
                     }
         }
        $logged_in = $this->CI->session->userdata('logged_in');
        if (($is_authentic && $logged_in)) {
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $session_vars =  $fields = $this->CI->config->item('auth_session_vars');
         foreach($session_vars as $var=>$column){
             $this->CI->session->unset_userdata($var);
         }
       return true;
    }

    public function get_user() {
        if ($this->is_logged_in()) {
            if (!is_object($this->_user)) {
                $tbl = $this->CI->config->item('auth_table');
                $user_id = $this->CI->session->userdata('user_id');
                 $query = $this->_prepare_query()->where('st.id',$user_id)
                         ->where('st.status_id','1')
                         ->get();
                 
               if($query->num_rows() == 1){
                  $rows = $query->result('Pmt_auth_user');
                  $this->_user =$rows[0];   
               }
               else
                 redirect('user/logout');
            }
        }

        return $this->_user;
    }

}

?>