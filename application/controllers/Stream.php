<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Stream extends MY_Controller {

         public function __construct()
        {
          parent::__construct();
        }
    
    
        public function index()
        {
        $data['news'] = $this->Stream_model->get_twitch();
       
        //$data['youtube'] = $this->Stream_model->get_youtube();
        
       // $data['news'] = array_merge($this->Stream_model->get_twitch(), $this->Stream_model->get_youtube());
        
        
        $this->Twitch_api_model->generic_update();
        $this->Twitch_api_model->group_update();
        //$this->Twitch_api_model->channel_update();
        
        $this->data['title'] = 'GamerTV';
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('stream/index',  $data);
        $this->load->view('templates/footer');
        }
        
        
        public function view($channel = NULL)
        {
                $this->data['news_item'] = $this->Stream_model->get_twitch($channel);

                
                if (empty($this->data['news_item']))
                {
                        show_404();
                }

                $this->data['title'] = "Gamer TV | ".ucfirst($channel)."";
                
                $this->data['channel'] = $channel;

                $this->load->view('templates/header', $this->data);
                $this->load->view('stream/view', $this->data);
                $this->load->view('templates/footer');
        }
        
        
}