<?php $this->tpl->load_element('flash_message');?>
<div class="box">
    <h3>Search Bulk Message</h3>
    <form method="post" action="<?php echo site_url($active_module.'/filter') ?>" >
   <table class="frm-tbl" cellpadding="0" cellspacing="0" border="0">
    <?php echo $this->bmf->render() ?>
    </table>
    </form>
</div>
<br>
<?php $this->tpl->load_element('grid_board')?>

