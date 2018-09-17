<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Simple_Twitch
 *
 * @author AlphaWolf
 */
class Simple_Twitch {
    
    public function __construct()
        {
                $this->load->library(array('curl'));
        }
        
                // Get all channels from a Group!
                public function get_group($group)
                {
                   $url ="https://api.twitch.tv/api/team/".$group."/all_channels.json";

                    if(is_array($result =$this->curl->get_signle_curl($url)))
                    {    
                                  foreach($result->channels as $value) 
                                          {
                                                   $data[] = array(
                                                      'name'   => $value->channel->name,
                                                      'display_name' => $value->channel->display_name,
                                                      'followers' => $value->channel->followers_count,
                                                      'views'   => $value->channel->total_views,
                                                      'status' => $value->channel->title,
                                                      'viewers' => $value->channel->current_viewers,
                                                      'game' => $value->channel->meta_game
                                                      );       
                                          }

                                    return $data;
                    }
                    else
                    {
                      return false;   
                    }
                }
                
                
                
                
                
                
}
