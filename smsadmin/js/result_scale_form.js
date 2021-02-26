$(document).ready(function(){
	 //for father ajax create.
	$("#frm-result-scale").validate();
	 
	 	
	 $("#scale_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Result scale title is required",
		 }
		});
		
	  	$('button.btn').click(function(){
	  	    var loc = window.location;
	        window.location=SITE_URL+'/sylabus/scale';
	   });
		
 });
