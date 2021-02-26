<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamil.com>
 * @ Created    May 12, 2011
 * class personaldetailsform
 */

class Balancereportform extends MT_Form{
    var $name = 'report';
	public function init()
	{
        $this->add_select('year',array(''=>'---- Select Year ----','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year')->set_validator('required');
		$this->add_select('month',array(''=>'---- Select Month ----','1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'))->set_label('Month');
		$this->add_input('day_from',array('style'=>'width:100px'))->set_label('Date From');
		$this->add_input('day_to',array('style'=>'width:100px'))->set_label('Date To');
		$this->add_submit('submit','Generate Report',array('class'=>'btn','style'=>'width:200px;'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));	   
	}
	
	public function get_model()
	{
		return 'balance_sheet_model';
	}
}
?>
