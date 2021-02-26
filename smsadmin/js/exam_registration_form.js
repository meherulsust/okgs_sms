$(document).ready(function(){

$(".admission").multiselect({checkAllText:'Select All',uncheckAllText:'Clear All',
	noneSelectedText:'Select Student',selectedText:'# Students Selected'});

	$('#btn-regi-cancel').click(function(){
	  $(dialog).dialog('close');
	});
        
	 //for father ajax create.
//	$("#frm-exam").validate();
/*	
jQuery.validator.addMethod("greaterThan", 
  function(value, element, params) {
    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');
	 
	 	$('#exam_class_id').selectChain({
	    target: $('#exam_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		  data:{class_id: 'exam_class_id'}
	});
	
	$('#exam_section_id').selectChain({
	    target: $('.syl'),
	    value:'title',
	    url: SITE_URL+'/json/sylabus/0',
	    type: 'post',
		  data:{class_id: 'exam_class_id',section_id:'exam_section_id'}
	});
	 
	$("#exam_sdatepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-01:+01",
	    altField:'#exam_start_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});
	$("#exam_edatepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-01:+01",
	    altField:'#exam_end_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});
	 
	 $("#exam_class_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Class name is required",
		 }
		});
	
	 $("#exam_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Syllabus name is required"
		 }
		});
		
	 $("#exam_fee").rules("add", {
		 required: true,
		 number:true,
		 messages: {
		   required: "Exam fee is required",
		   number: "Exam fee must be a number"
		 }
		});
		
		$("#exam_sdatepicker").rules("add", {
		 required: true,
		 date: true,
		 messages: {
		   required: " Start Date is required",
		   date: "Date format is not valid"
		 }
		});
		
		$("#exam_edatepicker").rules("add", {
		 required: true,
		 date: true,
		 greaterThan: "#exam_sdatepicker",
		 messages: {
		   required: "End Date is required",
		   date: "Date format is not valid",
		   greaterThan: "Start Date must be greater than End date"
		 }
		 
		});
	
	  	$('button.btn').click(function(){
	  	    var loc = window.location;
	  	   // alert(loc.protocol+"//"+loc.hostname+loc.pathname);
	        window.location=SITE_URL+'/sylabus/index';
	   });  */
  
 });
