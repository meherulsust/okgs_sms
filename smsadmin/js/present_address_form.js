$(document).ready(function(){
    //for father ajax create.
    var temp = {thana:0,post:0};
    $("#frm-present-address").validate({ 
        submitHandler: function(form) {
            $("#mtab").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#present_address_line").rules("add", {
        required: true,
        messages: {
            required: "Address is required"
        }
    });
    $('#frm-present-address #btn-cancel').click(function(){
        //	var index = stab.tabs("option",'selected');
        //stab.tabs( "url", index, $('#personal_cancel_url').val());
        //alert(index);
        stab.tabs('select',0);
    //event.preventDefault();
    });
    $('#present_district').selectChain({
        target: $('#present_thana'),
        value:'title',
        url: SITE_URL+'/json/thana',
        type: 'post',
        data:$(this).val(),
        afterSuccess: function(){
            $('#present_thana').val(temp.thana).trigger('change');
        }
    });
    $('#present_thana').selectChain({
        target: $('#present_post_office_id'),
        value:'title',
        url: SITE_URL+'/json/poffice',
        type: 'post',
        data:$(this).val(),
         afterSuccess: function(){
            $('#present_post_office_id').val(temp.post);
        }
    });
    
    $('#like_permanent').change(function(){
       var url = SITE_URL+'/json/address/' + $('#present_student_id').val();
       if($(this).is(':checked')){
                $("#mtab").mask('Loading ...');
                 $.get(url,function(responseText){
                 if(responseText.success){
                    $("#mtab").unmask();
                    var info = responseText.data;
                    temp.thana = info.thana_id;
                    temp.post = info.post_office_id;
                    $("#present_address_line").val(info.address_line);
                    $("#present_district").val(info.district_id).trigger('change');
                 }else{
                     flashMessage.container = '#std-present-address';
                     flashMessage.error(responseText.message);
                 }
                  $("#mtab").unmask();
              },'json');
           
       }else{
          $('#frm-present-address').trigger('reset');
          $(this).attr('checked',false);
          $("#present_district").trigger('change');
          $("#present_thana").trigger('change');
       }
       
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
        $('#std-present-address #ajax-flash').show().addClass('error').text(responseText.message);
    }
}
