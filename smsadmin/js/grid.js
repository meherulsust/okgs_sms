$(document).ready(function(){
	$('a.del_actn').click(function(event)
  {
     var ret = confirm('Are you sure? \nYou want to delete this record.');
     if(!ret)
      event.preventDefault();
  });
  //for sorting
  $('.grid-sort-link').click(function(event){
  	var str = $(this).attr('href');
  	str = str.replace('#','');
  	str = str.split('_');
  	$('#grid_sort_field').val(str[0]);
  	$('#grid_sort_type').val(str[1]);
  	$('#grid_page_offset').val(0);
  	$('#frm-grid').submit();
  	event.preventDefault();	
 });
//for pagination
 $('#tnt_pagination a').click(function(event){
  	var str = $(this).attr('href');
  	str = str.split('/');
  	$('#grid_page_offset').val(str.pop());
  	$('#frm-grid').submit();
  	 event.preventDefault();
 });


	
});
