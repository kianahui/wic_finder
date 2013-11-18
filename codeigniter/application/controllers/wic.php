<?php
class Wic extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('wic_model');
  }

  public function index() {
    $data['wic'] = $this->wic_model->get_sites();
    $data['pagetitle'] = 'WIC Database Manager';

    $this->load->view('wic/index', $data);
  }

public function new_clinic()
{
	$data['pagetitle'] = 'New WIC Center';
	$this->load->helper('form');
	$this->load->library('form_validation');

	//$data['Agency'] = 'Add A New Wic Center';

	$this->form_validation->set_rules('Agency', 'Agency', 'required');
	$this->form_validation->set_rules('Address1', 'Address1', 'required');
	$this->form_validation->set_rules('City', 'City', 'required');
	$this->form_validation->set_rules('State', 'State', 'required');
	$this->form_validation->set_rules('ZipCode', 'ZipCode', 'required');

	if ($this->form_validation->run() === FALSE)
	{
		$this->load->view('wic/new_clinic');;
	}
	else
	{
		$this->wic_model->set_wic();
		$this->load->view('wic/success');
	}
}
}
