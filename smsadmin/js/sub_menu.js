var dialog;
$(document).ready(function(){
    $('#add_sub_menu, .edit_actn, .view_actn').click(function(evnt){ 
        var url =  $(this).attr('href');
        dialog = $('<div>').dialog({
            modal: true,
            create: function (event, ui)
            {
                $(this).load(url);
            }, 
	        
            close: function(event, ui) {
                $(this).remove();
            },        
            height: 480,
            width: 600,
            title: 'Sub menu item form'
        });
	  
        evnt.preventDefault();
        $(".ui-dialog-content").mask("Loading...");
    });
});
