<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamil.com>
 * @ Created    May 12, 2011
 * class personaldetailsform
 */

class Smsreportform extends MT_Form{
    var $name = 'smsreport';
	public function init()
	{
		$this->add_file('csv_file')->set_label('Select File')->set_validator('required');
		$this->add_submit('submit','Update SMS Payment Report',array('class'=>'btn','style'=>'width:250px'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));	   
	}
	
	public function get_model()
	{
		return 'classmodel';
	}
}
?>
