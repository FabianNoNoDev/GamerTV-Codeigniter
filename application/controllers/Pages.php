<?php

class Pages extends MY_Controller {
    
         public function __construct()
        {
                parent::__construct();
		$this->load->helper(array('url','language'));
                $this->load->model('Pages_model');
                $this->data['page_title'] = $this->config->item('title');
                $this->data['user'] = json_decode(json_encode($this->ion_auth->user()->row()),true); 
        }
    
    
	public function view($page = 'generator')
            {
            

                    $this->data['title'] = ucfirst($page); // Capitalize the first letter
                    
                     $this->data['pages'] = $this->Pages_model->get_page($page);
                    

                    $this->load->view('templates/header', $this->data);
                    $this->load->view('pages/generator',  $this->data);
                    $this->load->view('templates/footer');
            }
}