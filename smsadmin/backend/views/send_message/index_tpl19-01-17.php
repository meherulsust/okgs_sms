<?php $this->tpl->load_element('flash_message'); ?>
<div class="box">
    <h3>SMS Information:</h3>
    <table class="frm-tbl" cellpadding="0" cellspacing="0" border="0">
    <tr>
		<td><strong>Purchased Total SMS :&nbsp;<span><?php echo $result[1];?></span></strong></td><td><strong>SMS Send :&nbsp;<span style='color:red'><?php echo $result[2];?></span></strong></td><td><strong>Available SMS :&nbsp;<span style='color:green'><?php echo $result[3];?></span></strong></td>
	</tr>
	
    </table>
</div>
<div class="box">
    <h3>Search Sent Message</h3>
    <form method="post" action="<?php echo site_url($active_module.'/filter') ?>" >
   <table class="frm-tbl" cellpadding="0" cellspacing="0" border="0">
    <?php echo $this->mf->render() ?>
    </table>
    </form>
</div>
<br>
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