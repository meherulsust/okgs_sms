<?php 
    $this->tpl->load_element('flash_message');
    $this->load->view('elements/record_view'); 
?>
<div class="btn-container"> 
    <a class="link-btn" title="Modify profile information" href="<?php echo site_url('profile/edit') ?>">Edit</a>
</div>
<script language="javascript">
    var dialog;
  $(document).ready(function(){
      $('.user_edit').click(function(evnt){
		  var url = SITE_URL+'/profile/password';
		  dialog = $('<div>').dialog({
		        modal: true,
		        create: function (event, ui)
		        {
		            $(this).load(url);
		        }, 
		        
		        close: function(event, ui) {
	               $(this).remove();
	           },        
		        height: 300,
		        width: 600,
		        title: 'Change password'
		    });
                 $(".ui-dialog-content").mask("Loading...");
		  evnt.preventDefault();
	   });

  });  
 
</script>
