$(document).ready(function(){
	 //for father ajax create.
	      
	$("#std-check").click(function(evnt){
        var std_number = $("#fee_generate_student_number").val();
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
	
	$('#fee_generate_month').change(function(){
		var year = $('#fee_generate_year').val();
		var month = $('#fee_generate_month').val();
		var student_number = $('#fee_generate_student_number').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/tuitionfee/get_head_list",
			data: "year="+year+"&month="+month+"&student_number="+student_number,
			success: function(response){  					
				$("#fee_generate_head_list_content").html(response);	
			}
		});		
	});
		
	$("#frm-book").validate();
	 
	$("#fee_generate_student_number").rules("add", {
		required: true,
		messages: {
			required: "Student Number is required"
		}
	}); 
	
	$("#fee_generate_year").rules("add", {
		required: true,
		messages: {
			required: "Year is required"
		}
	});
	
	$("#fee_generate_month").rules("add", {
		required: true,
		messages: {
			required: "Year is required"
		}
	});
	
	$("#fee_generate_start_date").rules("add", {
		required: true,
		messages: {
			required: "Start Date is required"
		}
	});
	$("#fee_generate_expire_date").rules("add", {
		required: true,
		messages: {
			required: "Expire Date is required"
		}
	});
	
        
	$('#cancell-btn').click(function(){
		window.location=SITE_URL+'/tuitionfee/partial_fee';
	}); 
	

	
  
 });
