<?php
class Centers_model extends CI_Model {
 
    /**
    * Responsible for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get center by his is
    * @param int $center_id 
    * @return array
    */
    public function get_center_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('centers');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    /**
    * Fetch centers data from the database
    * possibility to mix search, filter and order
    * @param int $manufacuture_id 
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_centers($manufacture_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('centers.id');
		$this->db->select('centers.description');
		$this->db->select('centers.stock');
		$this->db->select('centers.cost_price');
		$this->db->select('centers.sell_price');
		$this->db->select('centers.manufacture_id');
		$this->db->select('manufacturers.name as manufacture_name');
		$this->db->from('centers');
		if($manufacture_id != null && $manufacture_id != 0){
			$this->db->where('manufacture_id', $manufacture_id);
		}
		if($search_string){
			$this->db->like('description', $search_string);
		}

		$this->db->join('manufacturers', 'centers.manufacture_id = manufacturers.id', 'left');

		$this->db->group_by('centers.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $manufacture_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_centers($manufacture_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('centers');
		if($manufacture_id != null && $manufacture_id != 0){
			$this->db->where('manufacture_id', $manufacture_id);
		}
		if($search_string){
			$this->db->like('description', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_center($data)
    {
		$insert = $this->db->insert('centers', $data);
	    return $insert;
	}

    /**
    * Update center
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_center($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('centers', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete center
    * @param int $id - center id
    * @return boolean
    */
	function delete_center($id){
		$this->db->where('id', $id);
		$this->db->delete('centers'); 
	}
 
}
?>	
