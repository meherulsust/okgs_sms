<?php
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    November 01, 2015
 */
class Bulk_message_filter extends MT_Filter{
    var $name = 'bmfilter';
    public function init(){
        $this->add_input('message')->set_label('Message');
        $this->add_input('mobile')->set_label('Mobile No');
		$this->add_input('date')->set_label('Create Date');
        $this->add_select('status',array('All', 'SEND'=>'Send','NOT SEND'=>'Not Send'))->set_label('Status');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
