<?php $this->tpl->load_element('flash_message'); ?>
<?php $this->tpl->load_element('grid_board')?>
<script language="javascript">
    $(document).ready(function(){
        $('#msgfilter_class_id').selectChain({
	    target: $('#msgfilter_section_id'),
	    value:'title',
	    url: SITE_URL+'/json/admission_section',
	    type: 'post',
        data:{'admission_class_id': 'msgfilter_class_id' }
	});    
    });
</script>