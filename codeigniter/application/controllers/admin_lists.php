<?php
class Admin_lists extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lists_model');

        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $state = $this->input->post('state');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/lists';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;        


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
        if($state !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

            if($state !== 0){
                $filter_session_data['state_selected'] = $state;
            }else{
                $state = $this->session->userdata('state_selected');
            }
            $data['state_selected'] = $state;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            $data['foodLists'] = $this->lists_model->get_foodLists();

            $data['count_lists']= $this->lists_model->count_lists($state, $search_string, $order);
            $config['total_rows'] = $data['count_lists'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['foodLists'] = $this->lists_model->get_foodLists($state, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['foodLists'] = $this->lists_model->get_foodLists($state, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['foodLists'] = $this->lists_model->get_foodLists($state, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['foodLists'] = $this->lists_model->get_foodLists($state, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['state_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['state_selected'] = 0;
            $data['order'] = 'State';

            //fetch sql data into arrays
            $data['foodLists'] = $this->lists_model->get_foodLists();
            $data['count_lists']= $this->lists_model->count_lists();
            $data['foodLists'] = $this->lists_model-> get_foodLists('', '', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_lists'];

        }//!isset($state) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/lists/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('State', 'State', 'required');
            $this->form_validation->set_rules('Link', 'Link', 'required');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'State' => $this->input->post('State'),
                    'Link' => $this->input->post('Link')
                );
                //if the insert has returned true then we show the flash message
                if($this->lists_model->store_list($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
        //fetch manufactures data to populate the select field
        $data['foodLists'] = $this->lists_model->get_foodLists();
        //load the view
        $data['main_content'] = 'admin/lists/add';
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his State
    * @return void
    */
    public function update()
    {
        //list id 
        $id = $this->uri->segment(4);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('State', 'State', 'required');
            $this->form_validation->set_rules('Link', 'Link', 'required');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
 			'State' => $this->input->post('State'),
                    'Link' => $this->input->post('Link')
                );
                //if the insert has returned true then we show the flash message
                if($this->lists_model->update_list($state, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/lists/update/'.$state.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //list data 
        $data['foodList'] = $this->lists_model-> get_foodList_by_state($state);
        //fetch manufactures data to populate the select field
        $data['foodLists'] = $this->manufacturers_model->get_foodLists();
        //load the view
        $data['main_content'] = 'admin/lists/edit';
        $this->load->view('includes/template', $data);            

    }//update

    /**
    * Delete list by his id
    * @return void
    */
    public function delete()
    {
        //list id 
        $state = $this->uri->segment(4);
        $this->lists_model->delete_list($state);
        redirect('admin/lists');
    }//edit

}