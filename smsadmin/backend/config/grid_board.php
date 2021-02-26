<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /*
|--------------------------------------------------------------------------
| Grid board action settings.
|--------------------------------------------------------------------------
|
|
| Link used all over grid.
| format 
*/
$config['grid_all_actions'] = array(
                                    'view'=>array('title'=>'View','action'=>'show','controller'=>'','tips'=>'View details of this record'),
                                    'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit this record'),
                                    'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete this record'),
                                    'config'=>array('title'=>'Config','action'=>'config','controller'=>'','tips'=>'Configure this record'),
                                    'book'=>array('title'=>'Assign Subject','action'=>'book','controller'=>'','tips'=>'Assign subject'),
                                    'menu'=>array('title'=>'Assign Menu','action'=>'menu','controller'=>'','tips'=>'Assign menu'),
                                    'marks'=>array('title'=>'Assign Marks','action'=>'marks','controller'=>'','tips'=>'Assign exam marks'),
                                    'result'=>array('title'=>'Show result','action'=>'result','controller'=>'','tips'=>'Show result'),
                                    'transcript'=>array('title'=>'Transcript','action'=>'transcript','controller'=>'','tips'=>'Show transcript'),
                                    'eval'=>array('title'=>'Evaluation','action'=>'exameval','controller'=>'','tips'=>'Assign evaluation'),
                                    'certificate'=>array('title'=>'Transfer Certificate','action'=>'certificate','controller'=>'','tips'=>'generate transfer certificate'),
                                    'clstest' => array('title' => 'Assign Marks', 'action' => 'index', 'controller' => 'classtest', 'tips' => 'Create class test for this exam'),
                                    'studentlist'=>array('title'=>'Student List','action'=>'student','controller'=>'','tips'=>'View student list'),
                                   );
 /*
| Pagination will be loaded in grid board 
| if it is true. 
*/								
  $config['grid_pagination'] = true;
 /*
| Pagination element name 
*/	
  $config['grid_pagination_element'] = 'pagination'; 

/*
| Record displayed in grid per page. 
*/								
  $config['grid_record_per_page'] = 300;  

/*
| status menu will be avaiable for status column in grid 
| if it is true. 
*/	
  							
  $config['grid_status_menu'] = true; 
  
/*
| default status menu items
*/	
  $config['grid_status_menu_items'] = array('active'=>'Active','inactive'=>'Inactive','pending'=>'Pending'); 
/*
| Search  will be avaiable in grid 
| if it is true. 
*/	
  							
  $config['grid_search'] = true; 
 /*
| Search element name 
*/	
  $config['grid_search_element'] = 'grid_search'; 
  
/*
| default grid column option
*/
  $config['grid_column_option'] =  array('title'=>'','sort'=>true,'visible'=>true,'link'=>false,'status'=>false,'date'=>false,'datetime'=>false);
 
 /*
| default sort over given field during selecting record for grid
*/	
  $config['grid_sort_type'] = 'desc'; 
  $config['grid_sort_field'] = 'id';  
 
 
?>
