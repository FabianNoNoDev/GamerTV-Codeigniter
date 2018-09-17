<?php

class Ajax extends MY_Controller {

	 public function __construct()
        {
                parent::__construct();
		$this->load->helper(array('url'));
                $this->load->library(array('form_validation'));
                $this->load->model('Acp_model');
                $this->load->model('Pages_model');
                $this->load->model('Twitch_api_model');
                $this->load->model('Stream_model');
                $this->load->database();
                
                if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}     
                
                $this->data['debug'] = "";
        }
    
        
        public function generic_update()
            {
                $this->data['result'] = $this->Twitch_api_model->generic_update();
                
                $this->load->view('ajax/response',  $this->data);
            }
        
        public function group_update()
            {
                $this->data['result'] = $this->Twitch_api_model->group_update();
                
                $this->load->view('ajax/response',  $this->data);
            }
        
        public function update()
            {
                $this->data['result'] = $this->Twitch_api_model->generic_update();
                
                $this->load->view('ajax/response',  $this->data);
            }
        
        public function page_list()
            {
                $this->data['result'] = $this->Pages_model->get_all_page();
            
                $this->load->view('ajax/response',  $this->data);
            }
        
            
        public function delete_custom_twitch($name) // Get Custom Channels
        {
            $this->data['result'] = $this->Stream_model->delete_custom_twitch($name);
            
            $this->load->view('ajax/response',  $this->data);
        }        
            
            
        public function twitch_custom_list() // Get Custom Channels
        {
            $this->data['result'] = $this->Stream_model->get_custom_twitch();
            
            $this->load->view('ajax/response',  $this->data);
        }    
            
            
        public function twitch_group_list()
        {
            $this->data['result'] = $this->Stream_model->get_twitch_group();
            
            $this->load->view('ajax/response',  $this->data);
        }  
            
        public function delete_twitch_group($id)
            {
                $this->data['result'] = $this->Stream_model->twitch_group_delete($id);
            
                $this->load->view('ajax/response',  $this->data);
            }   
        
        
         public function delete_page($id)
            {
                $this->data['result'] = $this->Acp_model->delete_page($id);
            
                $this->load->view('ajax/response',  $this->data);
            }    
        
        public function banned_twitch()
            {
                $this->data['result'] = $this->Stream_model->get_twitch_banned();
            
                $this->load->view('ajax/response',  $this->data);
            }    
        
        public function twitch_unban($ban_name)
            {
                $this->data['result'] = $this->Stream_model->twitch_unban($ban_name);
            
                $this->load->view('ajax/response',  $this->data);
            } 
        
}