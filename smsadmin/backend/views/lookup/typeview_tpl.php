<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div id="rightnow">
<h3 class="reallynow"><span>View details  </span> <a href="<?php echo site_url($active_module.'/typeadd')?>" class="add" title='Create New category '>
Create Lookup Category</a> <br>
</h3></div>
<table class='view'>
<tbody>
<tr><th>Category Name:</th><td class='txt'><?php echo $title; ?></td>
<th>Category code:</th><td class='txt'><?php echo $unique_code; ?></td></tr>
<tr><th>Comments:</th><td class='txt'><?php echo $comments; ?></td>
<th>Created At:</th><td class='txt'><?php echo  mysql_to_audit($created_at); ?></td></tr>
<tr>
<th>Created By:</th><td class='txt'><?php echo ucfirst('admin'); ?></td>
<th>&nbsp;</th><td>&nbsp;</td></tr>
<tr><td colspan='4' class='btn-row'>
<a href='<?php echo site_url($active_module.'/typeedit/'.$id)?>' class='link-btn' title='Edit this record'>Edit</a>
<a href='<?php echo site_url($active_module.'/index')?>' class='link-btn' title='go to list'>Cancel</a>
</td></tr>
</tbody>
</table>
<div class='clr'></div>
<div id='grid'>
<?php $this->tpl->load_element('grid_board');?>
</div>
<div id='dialog-confirm'><div>Are you sure? You want to delete this value.</div></div>
<script language="javascript">
  $(document).ready(function(){
      
     $("a.del_actn").unbind('click').click(function(event){
       var url = $(this).attr('href');
       $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:140,
            width:400,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    location.href = url;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
       event.preventDefault();
     }); 
  });
</script>


