<?php 
$this->tpl->set_css('statusmenu');
$this->tpl->set_js('statusmenu.jquery');
?>
<div class="status-menu">
   <ul>
       <?php $grid_status_menu_items = array('not_approve'=>'Not Approve','approve'=>'Approve'); foreach($grid_status_menu_items as $key => $val): ?>
       <li class="sm-<?php  echo $key ?>  seprator"><a href="#" id="<?php echo $key ?>" > <?php echo $val ?></a></li>
       <?php endforeach; ?>
   </ul>
</div>
<script type="text/javascript">
   $(document).ready(function(){
      $('.change-status').statusMenu({menuBlock: 'status-menu'});
   });
</script>