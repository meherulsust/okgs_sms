$(document).ready(function(){
	//for father ajax create.
		
	$('#fee_generate_year').change(function(){
		var year = $('#fee_generate_year').val();
		var student_number = $('#fee_generate_student_number').val();
		$.ajax({
			type: "POST",
			url : SITE_URL+"/tuitionfee/get_month",
			data: "year="+year+"&student_number="+student_number,
			success: function(response){  					
				$("#fee_generate_month_list_content").html(response);	
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
	$("#month").rules("add", {
		required: true,
		messages: {
			required: "Month is required"
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
		window.location=SITE_URL+'/tuitionfee/advance';
	});  
	
	
});
