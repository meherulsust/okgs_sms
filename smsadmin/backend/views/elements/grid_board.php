<?php $has_status_menu = false; ?>
 <div id="box">
  <h3 class='grid_title_bar'><?php echo isset($list_title)? $list_title: 'Record list'; if(isset($grid_link)) echo $grid_link ?>  <br> </h3>
	<table width='100%'>
	 <thead>
		<tr>
		   <th class="first">#</th>
		   <?php $i=0; $visible_col=0; foreach($grid_columns as $field=>$opt):?>
		      <?php if($opt['visible']):?>
	           <?php if( $grid_page_info['total_records']==0 || (isset($opt['sort']) && $opt['sort']===false)): ?>
	                <th><?php echo $opt['title']; ?></th>
			   <?php else:?>
			 	 	<th>
			 	 	<a  href="<?php echo '#'.$i.'_'.$grid_sort_info['ntype']; ?>" class='grid-sort-link' title='Click To Sort In <?php echo $grid_sort_info['sort_full_name'] ?> Order' >
					<?php echo $opt['title'];?>
					<?php if($grid_sort_info['field'] == $i):?>
						<?php if($grid_sort_info['type']=='asc'):?>
							<img src="<?php echo $image_url ?>sort_a.gif" width="16" height="16" />
						<?php else:?>
							<img src="<?php echo $image_url ?>sort_d.gif" width="16" height="16" />
						<?php endif?>
					<?php endif?>	
					</a>
				   </th>
		 	  <?php endif?>
		 	 <?php $visible_col++; endif?> 
		   <?php $i++; endforeach; ?>	
			<th class="last">Action</th>
		</tr>
	</thead>
	<tbody>	
	<?php if($grid_page_info['total_records']>0):?>
		<?php foreach($grid_records as $i=>$row):?>
		    <tr <?php echo cycle(array('','class="bg"')) ?> > 
		     <td class='first'><?php echo $i+1 ?></td>
			<?php foreach($grid_columns as $fld=>$opt):?>
			        <?php if($opt['visible']):?> 
			          <td>
			          <?php if($opt['link']): ?> 
                                     <?php $link_id = isset($opt['id_column'])? $row[$opt['id_column']]: $row['id']  ?>
			             <a href='<?php echo site_url($opt['link'].'/'.$link_id) ?>' class='inner-link' title="<?php echo isset($opt['tips'])? $opt['tips']:"View Record Details"; ?>" > <?php echo $row[$fld] ?> </a>
			          <?php elseif($opt['status']): $stat_val= strtolower($row[$fld]); $has_status_menu = true; if(!strpos($opt['status'],'/')) $opt['status'] = $active_module.'/'.$opt['status']; ?> 
			             <a href='<?php echo site_url($opt['status'].'/'.$row['id']); ?>' class='change-status <?php  echo $stat_val; ?>' > <?php echo ucfirst($stat_val) ?> </a>
			          <?php elseif($opt['date']):?> 
			             <?php echo mysql_to_date($row[$fld]) ?>
			          <?php elseif($opt['datetime']):?> 
			             <?php echo mysql_to_audit($row[$fld]) ?>  
			          <?php else: ?> 
			             <?php echo $row[$fld] ?>
			          <?php endif ?>    
			         </td>
			       <?php endif ?>
		   <?php endforeach?>
		     <td class='action last'>
		        <?php foreach($grid_actions as $key=>$actn_opt):?>
		        <a  href='<?php echo site_url($actn_opt['controller'].'/'.$actn_opt['action'].'/'.$row['id'])?>' title='<?php echo $actn_opt['tips']?>' class='<?php echo $key?>_actn'><img src='<?php echo $image_url ?>actn_<?php echo $key ?>.png'  alt='<?php echo $actn_opt['title'] ?>' class='<?php echo $key ?>-icon' /></a>
		        <?php endforeach ?>
		        </td>
		    </tr>
		<?php endforeach?> 
	<?php else: ?>
	   <tr><td colspan='<?php echo $visible_col+2 ?>' class='no-record'>No record is found.</td></tr>
	<?php endif?>
	 </tbody>	
   </table>
 <?php if($this->config->item('grid_pagination')):?>
 <div id="pager">
        <div id="grid_total_record">
            <?php echo $grid_current_record.' records of '.$grid_total_records; ?>
        </div>    
 	<div id='tnt_pagination'>
	 <?php echo $grid_pagination_bar ?>
	</div>
  </div>	
  <?php endif?>
</div>

<form id="frm-grid" name="frm-grid" method='post' >
<input type='hidden' name='grid_page_offset' id='grid_page_offset'  value='<?php echo $grid_page_info['offset'] ?>' />
<input type='hidden' name='grid_sort_type' id='grid_sort_type' value='<?php echo $grid_sort_info['type'] ?>'/>
<input type='hidden' name='grid_sort_field' id='grid_sort_field'  value="<?php echo $grid_sort_info['field']?>" />
</form>
<?php if($this->config->item('grid_status_menu') && $has_status_menu) $this->tpl->load_element('status_menu'); ?>