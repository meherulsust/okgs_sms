<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    May 12, 2011
 * class guardian form
 */
class Photoform extends MT_Form{
	public function init()
	{
		$this->set_name('photo');
		$this->add_hidden('id');
		$this->add_hidden('student_id','');
	    $this->add_hidden('created_at',date('Y-m-d H:m:s'));
	    $this->add_file('image',array('class'=>'txt'))->set_label('Student Photo')
                    ->add_text_after('<span style="margin-left:25px;font-weight:bold;"> Max. Width x Height : 320x320, Max. Size : 120 KB</span>');
	    $this->add_submit('submit','Submit',array('class'=>'btn'));
	    $this->add_reset('button','Cancel',array('class'=>'btn cancel','id'=>'btn-cancel'));
	   
	}
	
	public function get_model()
	{
		return 'photomodel';
	}
}
?>