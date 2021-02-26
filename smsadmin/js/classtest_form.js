$(document).ready(function(){
	$("#frm-classtest").validate({ 
		 submitHandler: function(form) {
                                                   $(".ui-dialog-content").mask("Saving...");
                                                    $(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
        
  $("#classtest_title").rules("add", {
		 required: true,
		 messages: {
		   required: "Title is required"
		 }
		});

 $("#classtest_exam_type_lookup_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Exam type required"
		 }
		});
	
jQuery.validator.addMethod("greaterThan", 
  function(value, element, params) {
    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');
	 
	 
   $("#classtest_sdatepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#classtest_start_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});
	$("#classtest_edatepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
	    yearRange: "-02:+01",
	    altField:'#classtest_end_date',
	    dateFormat: 'd MM, yy',
	    altFormat: "yy-mm-dd"
	});
	
	
		
	$("#classtest_sdatepicker").rules("add", {
		 required: true,
		 date: true,
		 messages: {
		   required: " Start Date is required",
		   date: "Date format is not valid"
		 }
		});
		
		$("#classtest_edatepicker").rules("add", {
		 required: true,
		 date: true,
		 greaterThan: "#classtest_sdatepicker",
		 messages: {
		   required: "End Date is required",
		   date: "Date format is not valid",
		   greaterThan: "Start Date must be greater than End date"
		 }
		});
  $('#btn-cancel').click(function(){
	  $(dialog).dialog('close');
  });
  
   
    function saveSuccess(responseText, statusText, xhr, form) { 
		$(".ui-dialog-content").unmask();
		if(responseText.success)
		{	
		   $(dialog).dialog('close');
                   location.href = responseText.redirect;
		}	
		else
		{
                    flashMessage.error(responseText.message);
		}
 }
          	
 });
