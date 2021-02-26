<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Fefruary 23, 2013
 */

class Batch extends CI_Controller
{
	
        
        public function message($to = 'World')
	{
		echo "Hello {$to}!".PHP_EOL;
	}
        
        public function user($id=null){
            $this->load->model('usermodel');
            $info = $this->usermodel->find($id);
            print_r($info);
        }
	
}
?>