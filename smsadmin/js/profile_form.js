var dialog;
$(document).ready(function(){
    $("#frm-user").validate();
    $("#user_username").rules("add", {
        required: true,
        messages: {
            required: "Username is required"
        }
    });
     $("#user_full_name").rules("add", {
        required: true,
        messages: {
            required: "Username is required"
        }
    });
    $("#user_email").rules("add", {
        required: true,
        email: true,
        messages: {
            required: "Email is required",
            email: "Not a valid email address"
        }
    });
     $("#user_mobile_no").rules("add", {
        required: true,
        messages: {
            required: "Mobile no is required"
        }
    });
    
    $('#btn-cancel').click(function(){
       location.href = SITE_URL+"/profile";
    });
    
     $('#ch-pass').click(function(evnt){
		  var url = SITE_URL+'/profile/password';
		  dialog = $('<div>').dialog({
		        modal: true,
		        create: function (event, ui)
		        {
		            $(this).load(url);
		        }, 
		        
		        close: function(event, ui) {
	               $(this).remove();
	           },        
		        height: 300,
		        width: 600,
		        title: 'Change password'
		    });
                 $(".ui-dialog-content").mask("Loading...");
		  evnt.preventDefault();
	   });
});
