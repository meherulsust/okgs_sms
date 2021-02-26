<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class Balance_sheetform
 */
class Balance_sheetform extends MT_Form {

    var $name = 'bsheetform';

    public function init() {
        $this->add_hidden('id');
		$this->add_model_select('balance_title_id',array('model'=>'balance_titlemodel','where'=>'status = "ACTIVE"','add_empty'=>'--Select one--'))->set_label('Title')->set_validator('required');
		$this->add_select('balance_type',array(''=>'---- Select One ----','Income'=>'Income','Expenditure'=>'Expenditure'))->set_label('Type')->set_validator('required');
		/* $this->add_select('year',array(''=>'---- Select Year ----','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year')->set_validator('required');
		$this->add_select('month',array(''=>'---- Select Month ----','01'=>'January','02'=>'February','03'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'))->set_label('Month')->set_validator('required'); */
		$this->add_input('ammount',array('class'=>'txt'))->set_validator('required')->set_label('Amount');
		$this->add_input('date',array('style'=>'width:100px'))->set_label('Date')->set_validator('required');
		$this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'send_message'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn','id'=>'cancell-btn'), 'Cancel');
    }

    public function get_model() {
        return 'balance_sheet_model';
    }

}