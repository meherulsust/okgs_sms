$('#lnk-edit').click(function(event){
	var index = stab.tabs("option",'selected');	
	stab.tabs( "url", index, $(this).attr('href'));
	stab.tabs('load',index);
	event.preventDefault();
	});