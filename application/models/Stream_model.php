<?php

class Stream_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->model('Twitch_api_model');
        }
        
        
        public function get_custom_twitch()
        {
                        $this->db->select('name');
                        $this->db->from('stream_list');
                        $this->db->where('custom', 1);
                        $query = $this->db->get();
                        return $query->result_array();    
        }
        
        public function get_twitch_banned()
        {
                        $this->db->select('*');
                        $this->db->from('banned');
                        $this->db->join('stream_list', 'stream_list.name =banned.ban_name', 'left');
                        $this->db->where('banned =', 1);
                        $query = $this->db->get();
                        return $query->result_array();    
        }
        
        public function get_twitch_group()
        {
                        $this->db->select('*');
                        $this->db->from('stream_group');
                        $query = $this->db->get();
                        return $query->result_array();    
        }
        
         public function twitch_group_delete($id)
            {
                $this->db->delete('stream_group', array('id' => $id)); 

                return;
            }
        
         public function delete_custom_twitch($name)
            {
                $this->db->delete('stream_list', array('name' => $name)); 

                return;
            }
            
            
          public function twitch_unban($ban_name)
            {
                $this->db->delete('banned', array('ban_name' => $ban_name)); 

                return;
            }
        
          public function twitch_ban($ban_name)
                {
            
                $data = array(
		    'ban_name'   => $ban_name,
		    'banned' => 1
		);
            
                
                $this->db->insert('banned', $data);
                
                $id = $this->db->insert_id();
                
                return (isset($id)) ? TRUE : FALSE;
                }
            
                
                
        public function twitch_add($channel)
                {
            
                $data = array(
		    'name'   => $channel,
		    'custom' => 1
		);
            
                $this->db->insert('stream_list', $data);
                $id = $this->db->insert_id();
                
                // Update Aditional Fields
                $this->Twitch_api_model->channel_twitch_api($channel);
                $this->Twitch_api_model->channel_videos_twicht_api($channel);
                
                return (isset($id)) ? TRUE : FALSE;
                }       
                
        public function twitch_group($channel)
                {
            
                $data = array(
		    'name'   => $channel
		);
            
                
                $this->db->insert('stream_group', $data);
                
                $id = $this->db->insert_id();
                
                return (isset($id)) ? TRUE : FALSE;
                }      
        
        public function get_twitch($channel = FALSE)
        {
                if ($channel === FALSE)
                {
                        $this->db->select('*');
                        $this->db->from('stream_list');
                        $this->db->join('stream_update', 'stream_update.name = stream_list.name');
                        $this->db->join('banned', 'banned.ban_name = stream_list.name', 'left');
                        $this->db->where('online', 1);
                        $this->db->where('viewers >', 0);
                        $this->db->where('lang', $this->config->item('twitch_language'));
                        $this->db->where('banned.banned =', NULL);
                        $this->db->order_by("stream_list.viewers","desc");
                        $query = $this->db->get();
                        return $query->result_array();
                    
                 //       $query = $this->db->get_where('stream_update', array('online' => 1));
                  //      return $query->result_array();
                }
                
                return $channel;
        }
        
        public function get_youtube($channel = FALSE)
        {
      
                if ($channel === FALSE)
                {
                        $this->db->select('*');
                        $this->db->from('tube_list');
                        $this->db->join('tube_update', 'tube_update.name = tube_list.name');
                        $this->db->join('banned', 'banned.ban_name = tube_list.name', 'left');
                        $this->db->where('online', 1);
                        //$this->db->where('viewers >', 0);
                        $this->db->where('banned.banned =', NULL);
                        $this->db->order_by("tube_list.viewers","desc");
                        $query = $this->db->get();
                        return $query->result_array();
                    
                 //       $query = $this->db->get_where('stream_update', array('online' => 1));
                  //      return $query->result_array();
                }
                
                return $channel;

        }
        
        
        
}