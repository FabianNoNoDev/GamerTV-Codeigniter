<?php

class MY_Controller extends CI_Controller {

   public $site_options;

   function __construct() {
       parent::__construct();
       $this->load->helper(array('url','language'));
       $this->load->library(array('ion_auth','form_validation'));
       $this->load->model('Acp_model');
       $this->load->model('Pages_model');
       $this->load->model('Top_model');
       $this->load->model('Stream_model');
       $this->load->model('Twitch_api_model');
       $this->lang->load('auth');
       $this->load->database();
       $this->data['page_title'] = $this->config->item('title');
       $this->data['user'] = json_decode(json_encode($this->ion_auth->user()->row()),true); 
       $this->data['site_options'] = $this->site_options();
       $this->data['site_lang'] = $this->db_language();
       
       //Footer
       $this->data['footer_top'] = $this->Top_model->get_top(7);
       $this->data['footer_community'] = $this->Top_model->get_community();
       
       
   }
   
   
    protected function site_options() 
        {             
             $this->db->select('*');
             $this->db->from('site_options');
             $query = $this->db->get();
             
             $return = array();
                foreach ($query->result_array() as $value)
                {
                   $return[$value['name']] = $value['values'];
                }   
             return $return;
        }
        
    protected function db_language($lang = "hu") 
        {             
             $this->db->select('field_name,content');
             $this->db->from('site_lang');
             $this->db->where('lang', $lang);
             $query = $this->db->get();
             
             $return = array();
                foreach ($query->result_array() as $value)
                {
                   $return[$value['field_name']] = $value['content'];
                }   
             return $return;
        }    
        
   
   
   
   
   
   
   
   
}

