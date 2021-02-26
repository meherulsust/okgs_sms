$(document).ready(function(){
    
	$('#frm-teacher').validate();
    
	$("#teacher_name").rules("add", {
        required: true,
        messages: {
            required: "Full Name is required"
        }
    });
	
    $("#teacher_username").rules("add", {
        required: true,
        messages: {
            required: "Username is required"
        }
    });
	
   $("#teacher_passwd").rules("add", {
        required: true,
        messages: {
            required: "Passwd is required"
        }
    });
               
    $("#teacher_datepicker").rules("add", {
        required: true,
        date: true,
        messages: {
            required: "Date of Birth is required",
            date: "Not valid date format"
        }
    });
	
	$("#teacher_mobile_no").rules("add", {
        required: true,
        messages: {
            required: "Contact number is required"
        }
    });
	 
    $("#teacher_datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-50:-05",
        altField:'#teacher_dob',
        dateFormat: 'd MM, yy',
        altFormat: "yy-mm-dd"
    });

    $('#teacher_religion_id').selectChain({
        target: $('#teacher_caste_id'),
        value:'title',
        url: SITE_URL+'/json/caste',
        type: 'post',
        data:$(this).val()
    });
	
    
});
 

