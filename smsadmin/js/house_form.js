$(document).ready(function(){
	
	$("#frm-house").validate();	
	 
	$("#house_title").rules("add", {
		required: true,
		messages: {
			required: "Title is required."
		}
	}); 	    
   
	$('#cancell-btn').click(function(){
        window.location=SITE_URL+'/house/index';
	}); 
	
	
});
