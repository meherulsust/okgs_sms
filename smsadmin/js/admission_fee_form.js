$(document).ready(function(){
	 //for father ajax create.
	$("#frm-atf").validate();
	 
	 $("#aform_tuition_fee_head_id").rules("add", {
		 required: true,
		 messages: {
		   required: "Tuition fee head is required"
		 }
		});
		
          $("#aform_student_number").rules("add", {
		 required: true,
		 messages: {
		   required: "Student Number is required"
		 }
		});
		       
	 $("#aform_ammount").rules("add", {
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
  $("#std-check").click(function(evnt){
        var std_number = $("#aform_student_number").val();
        if(std_number =='')
        {
            $('.dialog-alert').dialog({
                modal: true,
                buttons:{
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                } 
            });
            return false;
    }       
    var url =  SITE_URL+'/transfer/stdinfo/'+ std_number;
   
   $('<div id="std-info">').dialog({
        modal: true,
        create: function (event, ui)
        {
            $(this).load(url);
        }, 
        close: function(event, ui) {
            $(this).remove();
        },        
        height: 320,
        width: 500,
        title: 'Student details information',
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
        }    
    });
    $('#std-info.ui-dialog-content').mask('Loading....');
    evnt.preventDefault();
    });
  
 });
