<?php 
 /**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 2, 2012
 * create a tree structure from query
 * that select data from pointer table 
 */
class Pmt_tree
{  
   private $_tree = array();
   private $_children = array();
   protected $CI;
   public function __construct()
   {
   	  $this->CI = &get_instance();
   	  $this->CI->load->library('tree/Pmt_node',null,'node'); 
   }
   
   public function set_query($query)
   {
      if($query instanceof CI_DB_mysqli_result )
   	  {
   	  	 $data = $query->result('Pmt_node');
   	  }
   	  else
   	  {
   	  	show_error('Tree: supplied argument is not a valid query object.');
   	  }
   	   $this->_prepare_tree($data);
   }
   
   private function _prepare_tree($data)
   {
   	  foreach($data as $node)
   	  {
   	  	 if(0 == $node->parent_id)
   	  	 {
   	  	 	$this->_tree[] =$node; 
   	  	 }
   	  	 else
   	  	 {
   	  	 	$this->_children[$node->parent_id][] = $node;
   	  	 }
   	  }
   }
   
   /*
    * return resultant tree
    */
   public function get_tree()
   {
   	  foreach($this->_tree as $parent)
   	  {
   	  	 $this->_find_child($parent);
   	  }
   	  return $this->_tree;
   }
   
   private function _find_child($parent)
   {
		if(array_key_exists($parent->id, $this->_children))
		{
			foreach($this->_children[$parent->id] as $child)
			{
				$parent->append_child($child);
				$this->_find_child($child);
			}
		}	
   }
   
}
?>