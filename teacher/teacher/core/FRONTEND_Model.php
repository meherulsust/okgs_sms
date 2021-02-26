<?php 
class Frontend_Model extends MT_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_created_by()
	{
		return $this->session->userdata('user_id');
	}
	
	public function get_assoc($table='')
	{
		$data=array();
		$table=empty($table)?$this->table:$table;
		$query=$this->db->get($table);
		$rows=$query->result_array();
		if(is_array($rows))
		{
			foreach($rows as $row)
 			{
				$temp=each($row);
				$num=count($row);
				if($num==1)
				{
					$data[$temp['value']]=$temp['value'];
				}
				elseif($num==2)
				{
					$data[$temp['value']]=array_pop($row);
				}
				else
				{
					$data[$temp['value']]=$row;
				}
 			}
 			return $data;

		}
	}
}

?>