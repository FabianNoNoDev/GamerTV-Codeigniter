<?php

class Top_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->time = time();
                $this->year = date("Y");
                $this->month = date("m");
                $this->week = date("W");
                $this->day = date("z")+1;
        }
        
        public function get_community()
        {

                        $this->db->select('count( name ) AS name, sum( followers ) AS followers, sum( views ) AS views');
                        $this->db->from('stream_list');
                        $query = $this->db->get();
                        return $query->row_array();
        }
        
        
        public function get_top($limit = 100)
        {
   
                        $this->db->select('*');
                        $this->db->from('stream_list');
                        $this->db->join('stream_update', 'stream_update.name = stream_list.name');
                        $this->db->order_by("views","desc");
                        $this->db->limit($limit);
                        $query = $this->db->get();
                        return $query->result_array();   
        }
        
        
        public function get_games($limit = 20)
        {
   
                        $this->db->select('count(`name`) AS count,`game`');
                        $this->db->from('stream_list');
                        $this->db->where('game !=',"");
                        $this->db->group_by("game"); 
                        $this->db->order_by("count","desc");
                        $this->db->limit($limit);
                        $query = $this->db->get();
                        return $query->result_array();   
        }
        
        public function get_videos($limit = 20)
        {
                        $this->db->select('name,videos');
                        $this->db->from('stream_list');
                        $this->db->order_by("videos","desc");
                        $this->db->limit($limit);
                        $query = $this->db->get();
                        return $query->result_array();   
        }
        
        public function get_partners($limit = 20)
        {
                        $this->db->select('name,followers');
                        $this->db->from('stream_list');
                        $this->db->where('partner', 1);
                        $this->db->order_by("followers","desc");
                        $this->db->limit($limit);
                        $query = $this->db->get();
                        return $query->result_array();   
        }
        
        public function get_views_day()
        {
                        $this->db->select('count(`name`) AS count,year,month,day');
                        $this->db->from('stream_meta');
                        $this->db->where('month', $this->month);
                        $this->db->where('year', $this->year);
                        $this->db->group_by('day'); 
                        $this->db->order_by("day","asc");
                        $this->db->limit(31);
                        $query = $this->db->get();
                        return $query->result_array();   
        }
        
        
        
        
        
        
        
        public function get_top100_weekly()
        {
            /*
            SELECT DISTINCT `stream_meta`.`name` , `stream_meta`.`week` , `stream_meta`.`views` , `stream_meta`.`followers`
            FROM `stream_list`
            LEFT JOIN `stream_meta` ON `stream_meta`.`name` = `stream_list`.`name`
            WHERE stream_meta.week =0
            GROUP BY `stream_meta`.`name`
            ORDER BY stream_list.views DESC
            LIMIT 100
             * 
             * 
                SELECT DISTINCT `stream_meta`.`name` , `stream_meta`.`week` , `stream_meta`.`views` , `stream_meta`.`followers`
                FROM `stream_list`
                LEFT JOIN `stream_meta` ON `stream_meta`.`name` = `stream_list`.`name`
                WHERE stream_meta.week =2
                GROUP BY `stream_meta`.`name`
                ORDER BY stream_list.views DESC
                LIMIT 100   
            */
            
            foreach (array_keys($tomb1 + $tomb2) as $key) {
                        $sums[$key] = (isset($tomb1[$key]) ? $tomb1[$key] : 0) - (isset($tomb2[$key]) ? $tomb2[$key] : 0);
                        }
            
        }     
        
        
        public function get_statistics($channel = FALSE)
        {
                if ($channel != "")
                {
                        $this->db->select('*');
                        $this->db->from('stream_meta');
                        $this->db->where('name', $channel);
                        $this->db->order_by("views","desc");
                        $this->db->limit(30);
                        $query = $this->db->get();
                        return $query->result_array();
                    
                 //       $query = $this->db->get_where('stream_update', array('online' => 1));
                  //      return $query->result_array();
                }

        }
        
        public function get_channel($channel = FALSE)
        {
                if ($channel != "")
                {
                        $this->db->select('*');
                        $this->db->from('stream_list');
                        $this->db->where('name', $channel);
                        $this->db->limit(1);
                        $query = $this->db->get();
                        return $query->row_array();
                    
                 //       $query = $this->db->get_where('stream_update', array('online' => 1));
                  //      return $query->result_array();
                }
                
                return $channel;
        }
        

     
}