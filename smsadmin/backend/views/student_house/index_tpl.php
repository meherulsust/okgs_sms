<?php $this->tpl->load_element('flash_message'); ?>
<div class="box">
    <h3>Search Student</h3>
    <form method="post" action="<?php echo site_url($active_module.'/filter') ?>" >
   <table class="frm-tbl" cellpadding="0" cellspacing="0" border="0">
    <?php echo $this->shf->render() ?>
    </table>
    </form>
</div>
<br>
<?php $this->tpl->load_element('grid_board')?>
<script language="javascript">
    $(document).ready(function(){
        $('#shfilter_class_id').selectChain({
	    target: $('#shfilter_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/admission_section',
	    type: 'post',
        data:{'admission_class_id': 'shfilter_class_id' }
	});    
    });
</script>