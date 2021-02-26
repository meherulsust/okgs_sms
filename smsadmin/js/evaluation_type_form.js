$(document).ready(function(){
	$("#frm-evaluation-type").validate();
	 
	 	
	 $("#eval_type_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Evaluation type is required"
		 }
		});
		$("#eval_type_eval_func").rules("add", {
		 required: true,
		 messages: {
		   required: "Evaluation function is required"
		 }
		});
	
	  	$('#cancel-btn').click(function(){
	  	    var loc = window.location;
	        window.location=SITE_URL+'/sylabus/evaltype';
	   });
		
 });
