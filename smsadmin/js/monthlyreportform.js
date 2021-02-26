$(document).ready(function(){
	 //for father ajax create.
	$("#report_day_from" ).datepicker({
		changeMonth: false,
		changeYear: false,
		//yearRange: "-50:-05",
		dateFormat: 'yy-mm-dd'
		
	});	
	
	$("#report_day_to" ).datepicker({
		changeMonth: false,
		changeYear: false,
		//yearRange: "-50:-05",
		dateFormat: 'yy-mm-dd'
		
	});
	
	$("#monthly-report").validate();
	 
	 $("#report_year").rules("add", {
		 required: true,
		 messages: {
		   required: "Year is required."
		 }
		});
		
        /*   $("#report_month").rules("add", {
		 required: true,
		 messages: {
		   required: "Month is required."
		 }
		});	 */	       
	 
  
 });
