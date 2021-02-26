$(document).ready(function(){
	 //for father ajax create.
	$("#frm-ctf").validate();
	 $("#ctf_class_id").rules("add", {
		 required: true,
                  remote: { url: SITE_URL+'/json/chkclassfee',type: 'post',
				   data:{
                                        head_id: function() { return $("#ctf_tuition_fee_head_id").val()},
                                        id: function() { return $("#ctf_id").val()}
				       }},
		 messages: {
		   required: "Class name is required",
                   remote: "Tuition fee head already exists for this class"
		 }
		});
	
	 $("#ctf_tuition_fee_head_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Tuition fee head is required"
		 }
		});
		
	 $("#ctf_ammount").rules("add", {
		 required: true,
		 number:true,
		 messages: {
		   required: "Ammount fee is required",
		   number: "Ammount  must be a number"
		 }
		});
		
	
	  	$('#cancell-btn').click(function(){
	  	    var loc = window.location;
	        window.location=SITE_URL+'/classtuitionfee/index';
	   });  
  
 });
