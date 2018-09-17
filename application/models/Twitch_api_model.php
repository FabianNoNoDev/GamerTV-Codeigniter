<?php

class Twitch_api_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->library(array('curl'));
                
                $this->time = time();
                $this->year = date("Y");
                $this->month = date("m");
                $this->week = date("W");
                $this->day = date("z")+1;  
        }
        
        
        
        
        
        
        
        public function group_update()
        {
           $this->db->select('*');
           $this->db->from('stream_group');
           $this->db->where('time <', $this->time-86400);
           $this->db->limit(1);
           $query = $this->db->get();
           $query = $query->row_array();  
           
           $result = "";
           
          if($query['name'])
                {
                       $url ="https://api.twitch.tv/api/team/".$query['name']."/all_channels.json";
            
                       if($this->curl->get_signle_curl($url))
                       {    
                       $result = $this->curl->get_signle_curl($url);
                       }
                       
                    if(is_array($result))
                    {   
                       foreach($result->channels as $value) 
                               {
                                        $data = array(
                                           'name'   => $value->channel->name,
                                           'display_name' => $value->channel->display_name,
                                           'followers' => $value->channel->followers_count,
                                           'views'   => $value->channel->total_views,
                                           'status' => $value->channel->title,
                                           'viewers' => $value->channel->current_viewers,
                                           'game' => $value->channel->meta_game
                                           );

                                       $this->db->replace('stream_list', $data);

                                       if($value->channel->status =="live")
                                       {
                                         $online = 1; 
                                       }
                                       else
                                       {
                                        $online = 0;   
                                       }    
                                           
                                       $stream_update_data = array(
                                           'name'   => $value->channel->name,
                                           'online'   => $online,
                                           'timecheck' => $this->time
                                           );
                                       $this->db->replace('stream_update', $stream_update_data);
                               }

                       $update = array('time' => $this->time);       
                       $this->db->where('name', $query['name']);
                       $this->db->update('stream_group', $update);                
              } 
                } 
        }
       
        
        public function channel_update()
        {
           $query = $this->db->get_where('cron_job', array('job' => 'custom'));
           $query = $query->result_array();  
           
          if($query[0]['time']<=($this->time-60))
                {
              
                        $this->db->select('name');
                        $this->db->from('stream_list');
                        $this->db->where('views >', 40000);
                        $this->db->or_where('custom', 1);
                        $this->db->order_by('name','random');
                        $this->db->limit(15);
                        $query2 = $this->db->get();
                        $query2 = $query2->row_array();
              

                       $stream_list="";
                       
                       foreach($query2 as $stream)
                       {
                        $channelName = $stream['name'];
			$stream_list.="".strtolower($channelName).",";   
                       }
                       $stream_list.="riot";
              
                       $url = "https://api.twitch.tv/kraken/streams?channel=".$stream_list."";

                       $result = $this->curl->get_signle_curl($url);

                       foreach($result->streams as $value) 
                               {
                                        $data = array(
                                           'name'   => $value->channel->name,
                                           'display_name' => $value->channel->display_name,
                                           'followers' => $value->channel->followers,
                                           'views'   => $value->channel->views,
                                           'status' => $value->channel->status,
                                           'viewers' => $value->viewers,
                                           'game' => $value->game,
                                           'large'   => $value->preview->large
                                           );

                                       $this->db->replace('stream_list', $data);

                                       $stream_update_data = array(
                                           'name'   => $value->channel->name,
                                           'online'   => 1,
                                           'timecheck' => $this->time
                                           );

                                       $this->db->replace('stream_update', $stream_update_data);

                                       $stream_meta_data = array(
                                           'name'   => $value->channel->name,
                                           'followers' => $value->channel->followers,
                                           'views'   => $value->channel->views,
                                           'year'   => $this->year,
                                           'month'   => $this->month,
                                           'week'   => $this->week,
                                           'day'   => $this->day
                                       );

                                       $this->db->replace('stream_meta', $stream_meta_data);  
                               }

                       $update = array('time' => $this->time);       
                       $this->db->where('job', 'custom');
                       $this->db->update('cron_job', $update);                
            }
        }
        
        
        
        public function generic_update()
        {
           $query = $this->db->get_where('cron_job', array('job' => 'stream'));
           $query = $query->result_array();  
           
          if($query[0]['time']<=($this->time-86400))
                {
                       $url = "https://api.twitch.tv/kraken/streams?language=".$this->config->item('twitch_language')."&limit=100";

                       $result = $this->curl->get_signle_curl($url);

                       foreach($result->streams as $value) 
                               {
                                        $data = array(
                                           'name'   => $value->channel->name,
                                           'display_name' => $value->channel->display_name,
                                           'followers' => $value->channel->followers,
                                           'views'   => $value->channel->views,
                                           'status' => $value->channel->status,
                                           'viewers' => $value->viewers,
                                           'game' => $value->game,
                                           'lang'   => $this->config->item('twitch_language'),
                                           'large'   => $value->preview->large
                                           );

                                       $this->db->replace('stream_list', $data);

                                       $stream_update_data = array(
                                           'name'   => $value->channel->name,
                                           'online'   => 1,
                                           'timecheck' => $this->time
                                           );

                                       $this->db->replace('stream_update', $stream_update_data);

                                       $stream_meta_data = array(
                                           'name'   => $value->channel->name,
                                           'followers' => $value->channel->followers,
                                           'views'   => $value->channel->views,
                                           'year'   => $this->year,
                                           'month'   => $this->month,
                                           'week'   => $this->week,
                                           'day'   => $this->day
                                       );

                                       $this->db->replace('stream_meta', $stream_meta_data);  
                               }

                       $update = array('time' => $this->time);       
                       $this->db->where('job', 'stream');
                       $this->db->update('cron_job', $update);                
              } 
    
        }      

        public function team_twitch_api_live($team)
        {
            $url ="https://api.twitch.tv/api/team/".$team."/live_channels.json";
            
            $result = $this->curl->get_signle_curl($url);
           
           return $result;
        }    
        
        
        public function team_twitch_api($team)
        {
            $url ="https://api.twitch.tv/api/team/".$team."/all_channels.json";
            
            $result = $this->curl->get_signle_curl($url);
           
           return $result;
        }      
        
        
        public function channel_videos_twicht_api($channel)
        {
           $url = "https://api.twitch.tv/kraken/channels/".$channel."/videos?limit=10"; 
            
           $result = $this->curl->get_signle_curl($url);
           
           if($result->_total > 0)
           {    
                $stream_list_data = array(
                 'videos' => $result->_total
                 );

                $this->db->where('name', $channel);
                $this->db->update('stream_list', $stream_list_data); 
           }
           
           return $result; 
            
        }        
        
        public function channel_twitch_api($channel)       
        {
           $url = "https://api.twitch.tv/kraken/channels/".$channel.""; 
           
           $result = $this->curl->get_signle_curl($url);
           
           if($result->partner == TRUE)
           {    
                $stream_list_data = array(
                 'partner' => 1
                 );

                $this->db->where('name', $channel);
                $this->db->update('stream_list', $stream_list_data); 
           }
           
           return $result;
        }
        

        
}