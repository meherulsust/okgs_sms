<?php if($this->input->is_ajax_request()):?>
<div id='menu-create'>
    <?php 
        $this->tpl->set_js(array('submenu_form')); 
        $this->load->view('menu/menu_form') 
     ?>
</div>
<?php else: ?>
<div id="box">
<h3 id="createmenu">
    <?php if($this->menuform->is_new()):?>
    <?php if($parent_id):?>Create sub menu item<?php else : ?> Create top menu item<?php endif;?>
    <?php else: ?>
    <?php if($parent_id):?> Edit sub menu item<?php else : ?> Edit top menu item <?php endif;?>
    <?php endif ?>
</h3>
<div id='menu-create'>
<?php $this->load->view('menu/menu_form') ?>
</div>
</div>
<?php endif ?>
<?php if(!$this->input->is_ajax_request()): ?>
<script language="javascript">
    $(document).ready(function(){
       $('#btn-cancel').click(function(event){
          location.href = "<?php echo site_url('menu/index'); ?>";
       }); 
    });
</script>
<?php endif ?>