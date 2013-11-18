<?php
class Wic_model extends CI_Model {

  public function __construct()	{
    $this->load->database();
  }
  
  public function get_sites() {
    $query = $this->db->get('foodList');
    return $query->result_array();
  }

  public function set_wic() {
    $data = array(
	'Agency' => $this->input->post('Agency'),
	'Address1' => $this->input->post('Address1'),
	'Address2' => $this->input->post('Address2'),
	'POBox' => $this->input->post('POBox'),
	'City' => $this->input->post('City'),
	'State' => $this->input->post('State'),
	'ZipCode' => $this->input->post('ZipCode'),
	'Phone' => $this->input->post('Phone'),
	'Link' => $this->input->post('Link')
	);

	return $this->db->insert('foodList', $data);
}
}
