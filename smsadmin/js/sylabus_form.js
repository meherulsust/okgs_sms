$(document).ready(function(){
	 //for father ajax create.
	$("#frm-sylabus").validate();
	 
	 	$('#sylabus_class_id').selectChain({
	    target: $('#sylabus_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:$(this).val()
	});
	 
	 $("#sylabus_class_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Class name is required"
		 }
		});
         $("#sylabus_result_scale_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Result scale is required"
		 }
		});        
	
	 $("#sylabus_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Syllabus name is required"
		 }
		});
	 $("#sylabus_total_marks").rules("add", {
		 required: true,
		 number:true,
		 messages: {
		   required: "Total marks is required"
		 }
		});
	
	  	$('button.btn').click(function(){
	  	    var loc = window.location;
	  	   // alert(loc.protocol+"//"+loc.hostname+loc.pathname);
	        window.location=SITE_URL+'/sylabus/index';
	   });  
  
 });
