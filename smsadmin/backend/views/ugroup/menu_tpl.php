<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<style type="text/css">
    #tree-cont{padding:10px 20px;}
    #tree-cont ul{
        list-style: none;
        width:600px;
    }
    #input-tree li{ line-height: 20px; vertical-align: middle; }
    #tree-cont ul ul{margin-left:20px; list-style: none;}
    li input{float: left; margin-top:5px;}
    #frm-assign-menu label {float:none; width:300px;}
    
</style>

<script language="javascript"> 
     
      
  /* 
    $(document).ready(function(){
        $('#input-tree li :checkbox').click(function(){
            $(this).parent().children('input').attr('checked',$(this).is(":checked"));
            
           // if($(this).is(":checked")){
               //$(this).parents('li.level_0').find('input').attr('checked',$(this).is(":checked"));
           // }else{
             //   $(this).parents('li.level_0').find('input').attr('checked',false);
           // }
        });
    });

(function ($) {
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };
  $("#chk_1").click(function(){alert('reza')});
  function listFilter(header, list) {
    var form = $("<form>").attr({"class":"filterform","action":"#"}),
        input = $("<input>").attr({"class":"filterinput","type":"text"});
    $(form).append(input).appendTo(header);
 
    $(input)
      .change( function () {
        var filter = $(this).val();
        if(filter) {
           $(list).find("label.ll_0:not(:Contains(" + filter + "))").parent().slideUp();
           $(list).find("label.ll_0:Contains(" + filter + ")").parent().slideDown();
        } else {
          $(list).find("li").slideDown();
        }
        return false;
      })
    .keyup( function () {
        $(this).change();
    });
  }
 
  $(function () {
    listFilter($("#search-box"), $("#input-tree"));
  });
  
 
  //$("input:checkbox").check(function(){alert('reza');});
}(jQuery));
 */
  </script> 
 <?php $this->tpl->load_element('flash_message'); ?>
<div id="box">
    <h3 id="add">Assign menu under <span style="color: #00620C"><?php echo $title ?></span> group</h3>
 <div id="tree-cont">
    
     <fieldset id="personal"><legend>MENU ITEM INFORMATION</legend>
     <form name="frm-assing-menu" id="frm-assign-menu" method="post" action="<?php echo site_url('ugroup/msave') ?>" >
         <input type="hidden" name="group_id" value="<?php echo $id ?>">
 <ul id="input-tree">   
 <?php 
       $menu = $this->menumodel->get_active_backend_menu_tree();
       $prev_data = $this->ugmmodel->get_group_menu($id);
       $data = array();
        if($prev_data){
         $data = array_assoc_by_key($prev_data, 'menu_id');
        }
        foreach($menu as $node){
            render_node_input($node,0,$data);
        }
    ?>
  </ul>
         <input type="submit" value="save" class="btn" />
     </form>
         </fieldset>
 </div>
</div>
<?php
  function render_node_input($node,$l,$old_data){
       $checked ="";
       if(isset($old_data[$node->id])){
            $checked ="checked='checked'";
       }
       echo '<li class="level_'.$l.'" ><input name ="menus[]"'.$checked.' type="checkbox" id="chk_'.$node->id.'" value= "'.$node->id.'"/> <label for="chk_'.$node->id.'" class="ll_'.$l.'">'.$node->title.'</label>';
       $children = $node->get_children();
       if(count($children)>0){
           echo '<ul>';
           foreach( $children as $cnode)
                 render_node_input($cnode,++$l,$old_data);
           echo "</ul></li>";      
        
        
       }else{
           echo "</li>\n";
       }
       
  }
?>

