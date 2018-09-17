<?php

class Pages_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
       
        public function get_page_data($slug)
        {
                        $this->db->select('id,parent_id,title,content');
                        $this->db->from('pages');
                        $this->db->where('slug', $slug);
                        $this->db->limit(1);
                        $query = $this->db->get();
                        return  $query->row_array();

        }
        
        public function get_all_page()
        {
                        //Get Slug

                        $this->db->select('*');
                        $this->db->from('pages');
                        $this->db->order_by("id","desc");
                        $query = $this->db->get();
                        return $query->result_array();
        }
        
        public function get_page($page = FALSE)
        {
                        //Get Slug
                        $query = $this->get_page_data($page);
            
                        $page_id = intval($query['id']);
                        
                        $this->db->select('*');
                        $this->db->from('pages');
                        $this->db->where('id', $page_id);
                        $this->db->or_where('parent_id', $page_id);
                        $this->db->order_by("id","asc");
                        $query = $this->db->get();
                        return $query->result_array();
                    

        }
        
}