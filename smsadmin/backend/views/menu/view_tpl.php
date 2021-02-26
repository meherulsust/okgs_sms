<?php $this->tpl->load_element('flash_message'); ?>
<div id='ajax-flash'></div>
<div id="rightnow">
    <h3 class="reallynow"><span>Top Menu Details  </span> <a href="<?php echo site_url($active_module . '/create') ?>" class="add" title='Create Top Menu '>
            Create Top Menu</a> <br>
    </h3>
    <table class='view'>
        <tbody>
            <tr><th>Top Menu Title:</th><td class='txt'><?php echo $title; ?></td>
                <th>Alias:</th><td class='txt'><?php echo $alias; ?></td></tr>
            <tr><th>Tips:</th><td class='txt'><?php echo $tips; ?></td>
                <th>Sequence:</th><td class='txt'><?php echo $serial ?></td></tr>

            <tr><th>Menu Type:</th><td class='txt'><?php echo $type; ?></td>
                <th>Status:</th><td class='txt'><?php echo ucfirst(strtolower($status)); ?></td></tr>
            <tr><th>Created At:</th><td class='txt'><?php echo mysql_to_audit($created_at); ?></td>
                <th>Created By:</th><td class='txt'><?php echo ucfirst('admin'); ?></td></tr>
            <tr><td colspan='4' class='btn-row'>
                    <a href='<?php echo site_url($active_module . '/edit/' . $id) ?>' class='link-btn' title='Edit top menu'>Edit Top Menu</a>
                    <a href='<?php echo site_url($active_module . '/index') ?>' class='link-btn' title='go to list'>Back</a>
                </td></tr>
        </tbody>
    </table>
</div>
<div id='dialog-confirm'><div>Are you sure? You want to delete this sub menu item.</div></div>
<div class='clr'></div>
<div id='grid'>
    <?php $this->tpl->load_element('grid_board'); ?>
</div>
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


