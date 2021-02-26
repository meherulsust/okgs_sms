
<?php 
$this->tpl->set_js(array('jquery.validate','jquery.form', 'jquery.loadmask'));
$this->tpl->set_css(array('jquery.loadmask'));		
$this->tpl->load_element('flash_message');
?>
<div>
<?php $this->load->view('sylabus/course_type_course_attribute_form'); ?>
</div>