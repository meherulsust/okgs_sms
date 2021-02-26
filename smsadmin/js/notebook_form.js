$(document).ready(function(){
    
	$('#frm-notebook').validate();
    
	$("#notebook_title").rules("add", {
        required: true,
        messages: {
            required: "Title is required"
        }
    });
	
	$("#notebook_subject_id").rules("add", {
        required: true,
        messages: {
            required: "Subject is required"
        }
    });
	
	$("#notebook_class_id").rules("add", {
        required: true,
        messages: {
            required: "Class is required"
        }
    });

    $('#notebook_class_id').selectChain({
        target: $('#notebook_section_id'),
        value:'title',
        url: SITE_URL+'/json/section',
        type: 'post',
        data:{class_id: 'notebook_class_id'}
    });
	
    
});
 

