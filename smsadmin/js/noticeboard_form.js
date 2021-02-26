$(document).ready(function(){
	//for father ajax create.
	$('#notice_board_class_id').selectChain({
	    target: $('#notice_board_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
		data:{class_id: 'notice_board_class_id'}
	});
	
	$("#frm_send_notice").validate();
	 
	$("#notice_board_notice_title").rules("add", {
		required: true,
		messages: {
			required: "Notice title is required."
		}
	}); 
	
	$("#notice_board_full_notice").rules("add", {
		required: true,
		messages: {
			required: "Full Notice is required."
		}
	}); 
	 
	
	
});
