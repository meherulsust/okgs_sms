<?php
/**
 * report student filter
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 21, 2014
 */
class StudentpaymentFilter extends MT_Filter{
    var $name = 'stdpf';
    public function init(){
        
        $this->add_input('student_number')->set_label('Student Id');
        $this->add_input('full_name')->set_label('Name');
        $this->add_input('mobile')->set_label('Mobile');
        $this->add_select('pay_status',array('All', 'PAID'=>'Paid','UNPAID'=>'Unpaid'))->set_label('Payment Status');
		$this->add_model_select('payment_class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))
               ->set_label('Class');
        $this->add_model_select('payment_section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('payment_class_id',0)."'",'add_empty'=>'--Select Form--'))
                            ->set_label('Form');
        $this->add_select('year',array(''=>'---- Select Year ----','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year');
		$this->add_select('month',array(''=>'----Select Month----','1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'))->set_label('Month');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
        
        
    }
    public function build_condition1($model) {
        if($this->values['gender']){
            $model->db->where('gender',$this->values['gender']);
        }
    }
}
?>