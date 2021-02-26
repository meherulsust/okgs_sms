$(document).ready(function(){
    
	$('#frm-stuff').validate();
    
	$("#stuff_name").rules("add", {
        required: true,
        messages: {
            required: "Full Name is required"
        }
    });
	     
    $("#stuff_designation_id").rules("add", {
        required: true,
        messages: {
            required: "Stuff Designation is required",
            
        }
    });
	 $("#stuff_order").rules("add", {
        required: true,
        messages: {
            required: "Stuff order is required",
            
        }
    });
	
	$("#stuff_edulabel").rules("add", {
        required: true,
        messages: {
            required: "Stuff education label is required",
            
        }
    });
	
	$("#stuff_datepicker").rules("add", {
        required: true,
        date: true,
        messages: {
            required: "Date of Birth is required",
            date: "Not valid date format"
        }
    });
	
	$("#stuff_mobile_no").rules("add", {
        required: true,
        messages: {
            required: "Contact number is required"
        }
    });
	 
    $("#stuff_datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-50:-05",
        altField:'#stuff_dob',
        dateFormat: 'd MM, yy',
        altFormat: "yy-mm-dd"
    });

    $('#stuff_religion_id').selectChain({
        target: $('#stuff_caste_id'),
        value:'title',
        url: SITE_URL+'/json/caste',
        type: 'post',
        data:$(this).val()
    });
	
    
});
 

