$(document).ready(function(){
    // without ajax.
    $('#std-create #frm-personal-info').validate();
    //for ajax create.
    $("#std-edit #frm-personal-info").validate({ 
        submitHandler: function(form) {
            $("#mtab").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#personal_student_number").rules("add", {
        required: true,
        minlength: 4,
        messages: {
            required: "Student Number Name is required"
        }
    });
	$("#personal_first_name").rules("add", {
        required: true,
        minlength: 3,
        messages: {
            required: "First Name is required",
            minlength: jQuery.format("Please, at least {0} characters are necessary")
        }
    });
    $("#personal_mobile").rules("add", {
        required: true,
        messages: {
            required: "Contact number is required"
        }
    });            
    $("#personal_datepicker").rules("add", {
        required: true,
        date: true,
        messages: {
            required: "Date of Birth is required",
            date: "Not valid date format"
        }
    });
	

	 
    $("#personal_datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-50:-02",
        altField:'#personal_dob',
        dateFormat: 'd MM, yy',
        altFormat: "yy-mm-dd"
    });

    $('#personal_religion_id').selectChain({
        target: $('#personal_caste_id'),
        value:'title',
        url: SITE_URL+'/json/caste',
        type: 'post',
        data:$(this).val()
    });
	
    $('#std-edit #btn-cancel').click(function(){
        var index = stab.tabs("option",'selected');
        var cancel_url = SITE_URL+'/student/personal/'+$('#personal_student_id').val()+'/'+$('#personal_id').val();
        stab.tabs( "url", index,cancel_url);
        stab.tabs('load',index);
    //event.preventDefault();
    });
});
 
function saveSuccess(responseText, statusText, xhr, $form) { 
    $("#mtab").unmask();
    if(responseText.success)
    {	
        var index = stab.tabs("option",'selected');
        stab.tabs( "url", index,responseText.redirect);
        stab.tabs('load',index);
    }	
    else
    {
        $('#std-edit #ajax-flash').show().addClass('error').text(responseText.message);
    }
}
 
