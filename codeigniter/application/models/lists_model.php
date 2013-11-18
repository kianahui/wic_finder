<?php
class Lists_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get list by his is
    * @param int $product_id 
    * @return array
    */
    public function get_foodList_by_state($state)
    {
		$this->db->select('*');
		$this->db->from('foodList');
		$this->db->where('State', $state);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch lists data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_foodLists($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('foodList');

		if($search_string){
			$this->db->like('State', $search_string);
		}
		$this->db->group_by('State');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_lists($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('lists');
		if($search_string){
			$this->db->like('State', $search_string);
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
    function store_manufacture($data)
    {
		$insert = $this->db->insert('foodList', $data);
	    return $insert;
	}

    /**
    * Update listEntry
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_list($state, $data)
    {
		$this->db->where('State', $state);
		$this->db->update('foodList', $data);
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
    * Delete list
    * @param int $id - manufacture id
    * @return boolean
    */
	function delete_manufacture($state){
		$this->db->where('State', $state);
		$this->db->delete('foodList'); 
	}
 
}
?>	
