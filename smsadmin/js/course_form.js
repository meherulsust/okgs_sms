$(document).ready(function(){
 
    $(".book-list").multiselect({
        checkAllText:'Select All',
        uncheckAllText:'Clear All',
        noneSelectedText:'Select Book',
        selectedText:'# Books Selected'
    });
    $("#frm-course").validate({ 
        submitHandler: function(form) {
            $(".ui-dialog-content").mask("Saving...");
            $(form).ajaxSubmit({
                success: saveSuccess
            });
        }
    });
    $("#course_course_title_id").rules("add", {
        required: true,
        messages: {
            required: "Subject title is required"
        }
    });
    $("#course_serial").rules("add", {
        required: true,
        messages: {
            required: "Display serial is required"
        }
    });
	
    $("#course_code").rules("add", {
        required: true,
        messages: {
            required: "Subject code is required"
        }
    });
    $("#course_total_marks").rules("add", {
        required: true,
        number:true,
        messages: {
            required: "Total marks is required",
            number:  "Total marks must be a number"
        }
    });
    $("#course_sylabus_course_type_id").rules("add", {
        required: true,
        messages: {
            required: "Course type is required"
        }
    });
  	
    $('#frm-course #btn-cancel').click(function(){
        $(dialog).dialog('close');
    });
});
 
function saveSuccess(responseText, statusText, xhr, $form) { 
    $(".ui-dialog-content").unmask();
    if(responseText.success)
    {	
        $(dialog).dialog('close');
        var index = stab.tabs("option",'selected');
        // stab.tabs( "url", index,responseText.redirect);
        stab.tabs('load',index);
		
    }	
    else
    {
        $('#Course_Type #ajax-flash').show().addClass('error').text(responseText.message);
    }
}
