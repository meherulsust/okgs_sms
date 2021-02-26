<div id="rightnow">
<h3 class="reallynow">
  <span> <?php echo isset($view_title) ? $view_title : 'Record details' ?> </span> 
  <?php if(isset($view_button)): ?>
  <?php $cls = isset($view_button['class']) ?  $view_button['class'] : "add" ; ?>
  <a href="<?php echo site_url($view_button['url']) ?>" class="<?php echo $cls ?>" title='<?php echo $view_button['alt']?>' ><?php echo $view_button['title']?></a> 
  <?php endif; ?>
  <br>
</h3>
<table class='view'>
 <tbody>
     <?php foreach ($labels as $fld => $lbl): ?>
     <tr><th class='lbl'><?php echo is_array($lbl) ? $lbl['title'] : $lbl ;  ?></th><td class='cln'>:</td><td class='txt'>
         <?php 
             if(in_array($fld,array('created_at','updated_at')))
              echo mysql_to_audit($row[$fld]); 
             else if($fld == 'status')
              echo ucfirst(strtolower($row[$fld]));
             else if(is_array($lbl) && $lbl['type'] == 'image') 
                 echo "<img src='".$lbl['path'].$row[$fld]."' width='".$lbl['width']."' height='".$lbl['width']."'  />";
             else
              echo $row[$fld];
         ?></td></tr>
     <?php endforeach; ?>
 </tbody>
</table>
    <?php if($this->input->is_ajax_request()): ?>
     <div class="btn-container" style="text-align: center;"> <button id="btn-cancel-view" class="btn" style="margin:1px 100px;" type="button">Cancel</button></div>
     <script language="javascript">
        $('#btn-cancel-view').click(function(){
             $(dialog).dialog('close');
        });  
     </script>
     
     <?php endif ?>
</div>