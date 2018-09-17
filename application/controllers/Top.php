<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top extends MY_Controller {

         public function __construct()
        {
                parent::__construct();
                $this->load->model('Top_model');
                $this->load->model('Twitch_api_model');
                $this->load->helper('url_helper');
                $this->data['page_title'] = $this->config->item('title');
                $this->data['user'] = json_decode(json_encode($this->ion_auth->user()->row()),true); 
        }
    
    
        public function index()
        {
        //$data['news'] = $this->Stream_model->get_news();
       
        $this->data['top_list'] = $this->Top_model->get_top();
        $this->data['community'] = $this->Top_model->get_community();
        
        $this->data['title'] = 'GamerTV';
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('top/index', $this->data);
        $this->load->view('templates/footer');
        }
        
        public function view($channel = NULL)
        {
              $this->data['statistics'] = $this->Top_model->get_statistics($channel);

              $this->data['channeldata'] = $this->Twitch_api_model->channel_twitch_api($channel);
              
              $this->data['channelvideos'] = $this->Twitch_api_model->channel_videos_twicht_api($channel);
              
              if (empty($this->data['statistics']))
              {
                        show_404();
              }

                $this->data['title'] = "Gamer TV | ".ucfirst($channel)."";
                
                $this->data['channel'] = $channel;

                $this->load->view('templates/header', $this->data);
                $this->load->view('top/view', $this->data);
                $this->load->view('templates/footer');
        }
        
        
}