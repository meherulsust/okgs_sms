$(document).ready(function(){
	$("#frm-exam-course-eval").submit(function(event){
              $(".ui-dialog-content").mask("Saving...");
              $(this).ajaxSubmit({success: saveSuccess});
              event.preventDefault();
        });
        
        $('#cancel-btn').click(function(){
         $(dialog).dialog('close');
        });  

        $(".tbl-inner input").keyup(function(event){
            var total = 0;
            $(this).parents('table.tbl-inner').find('td input').each(function(){
               var num = parseInt($(this).val());
               var elem_id ='#marks_', str;
               
               if(!isNaN(num)){
                   total += num;
                  str = $(this).attr('id')
                  elem_id += str.split('_')[0];
                  $(elem_id).val(total);
               }
              
            });
        });
 });
 
 
 
 function saveSuccess(responseText, statusText, xhr, $form) { 
		$(".ui-dialog-content").unmask();
               
		if(responseText.success)
		{	$(dialog).dialog('close');
                        flashMessage.success(responseText.message);
		}	
		else
		{
			 flashMessage.error(responseText.message);
		}
 }

