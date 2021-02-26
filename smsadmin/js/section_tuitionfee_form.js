$(document).ready(function(){
	$("#frm-stf").validate();
	 
	$('#stf_class_id').selectChain({
	    target: $('#stf_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/section',
	    type: 'post',
            data:{class_id: 'stf_class_id'},
            afterSuccess:function(){
                  $("#stf_section_id").rules("add", {
		 required: true,
                  remote: { url: SITE_URL+'/json/chksectionfee',type: 'post',
				   data:{
                                        head_id: function() { return $("#stf_tuition_fee_head_id").val()},
                                        id: function() { return $("#stf_id").val()}
				       }},
		 messages: {
		   required: "Form name is required",
                   remote: "Tuition fee head already exists for this section"
		 }
		});
	
            }
            
	});
	 
	 $("#stf_class_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Class name is required"
		 }
		});
	
	 $("#stf_tuition_fee_head_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Tuition fee head is required"
		 }
		});
		
	 $("#stf_ammount").rules("add", {
		 required: true,
		 number:true,
		 messages: {
		   required: "Ammount fee is required",
		   number: "Ammount  must be a number"
		 }
		});
		
	
	  	$('#cancell-btn').click(function(){
	        window.location=SITE_URL+'/sectiontuitionfee/index';
	   });  
  
 });
