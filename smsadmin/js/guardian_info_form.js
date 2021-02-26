$(document).ready(function(){
	 //for father ajax create.
	$("#frm-guardian-info").validate({ 
		 submitHandler: function(form) {
			  				$("#mtab").mask("Saving...");
						 	$(form).ajaxSubmit({success: saveSuccess});
	 					}
	 });
	$("#guardian_first_name").rules("add", {
		 required: true,
		 minlength: 3,
		 messages: {
		   required: "First Name is required",
		   minlength: jQuery.format("Please, at least {0} characters are necessary")
		 }
		});
	
	$('#frm-guardian-info #btn-cancel').click(function(){
	//	var index = stab.tabs("option",'selected');
		//stab.tabs( "url", index, $('#personal_cancel_url').val());
		//alert(index);
		stab.tabs('select',0);
		//event.preventDefault();
	});
        
        $('#guardian_relationship_id').change(function(){
            var std_id = $('#guardian_student_id').val();
            var url='';
            var val = $(this).val();
            switch(val){
                case '30' :
                //$('#std-guardian input[type=text]').attr('readonly', true); 
                url = SITE_URL + '/json/guardian/'+std_id+'/father';
                load_data(url);
                break;
                case '29' :
                     url = SITE_URL + '/json/guardian/'+std_id+'/mother';
                     load_data(url);
                     break;
                default:
                    $("#frm-guardian-info").trigger('reset');
                    $(this).val(val);
                    break;
            }   
        });
        
       function load_data(url){
                 $("#mtab").mask('Loading ...');
                 $.get(url,function(responseText){
                 if(responseText.success){
                    $("#mtab").unmask();
                    var info = responseText.data;
                    $("#guardian_first_name").val(info.first_name);
                    $("#guardian_last_name").val(info.last_name);
                    $("#guardian_anual_income").val(info.anual_income);
                    $("#guardian_national_id").val(info.national_id);
                    $("#guardian_mobile").val(info.mobile);
                    $("#guardian_occupation_id").val(info.occupation_id);
                 }else{
                     flashMessage.container = '#std-guardian';
                     flashMessage.error(responseText.message);
                 }
                 
              },'json');
            }
  });
  

 function saveSuccess(responseText, statusText, xhr, $form) { 
		$("#mtab").unmask();
		if(responseText.success)
		{	
			//$('#std-guardian #ajax-flash').show().addClass('error').text(responseText.message);
			 var index = stab.tabs("option",'selected');
		   stab.tabs( "url", index,responseText.redirect);
			 stab.tabs('load',index);
		
		}	
		else
		{
			$('#std-guardian #ajax-flash').show().addClass('error').text(responseText.message);
		}
 }
