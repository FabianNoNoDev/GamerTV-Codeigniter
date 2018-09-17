<?php

class Acp_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        

        public function parent_pages()
        {

                        $this->db->select('id,title');
                        $this->db->from('pages');
                        $this->db->where('parent_id', 0);
                        $this->db->order_by("id","asc");
                        $result = $this->db->get(); 
                        $return = array();
      
                        $return[''] = 'New Parent';
                        
                        if($result->num_rows() > 0){
                            
                                foreach($result->result_array() as $row){
                                $return[$row['id']] = $row['title'];
                                }
                                }    
                                
                return $return;                
                                
        }
        
        
        public function delete_page($id)
        {
            $this->db->delete('pages', array('id' => $id)); 
           
            return;
        }
        
        
        
        
        
        public function edit_page($parent,$slug,$title,$content)
        {
            
                if($parent!==0)
                {
                    $query = $this->db->get_where('pages',array('id' => $parent),1)->row();

                    if(!isset($query->id))
                    {
                        return 'Parent Page not Exist!';
                    }
                }
            
                $data = array(
		    'parent_id'   => $parent,
		    'slug' => $slug,
                    'title' => $title,
		    'content' => $content
		);
            

                $this->db->where('slug', $slug);
                $this->db->update('pages', $data);
                
                $id = $this->db->insert_id();
                
                return (isset($id)) ? TRUE : FALSE;
        }
        
        public function add_page($parent,$slug,$title,$content)
        {
            
                if($parent!==0)
                {
                    $query = $this->db->get_where('pages',array('id' => $parent),1)->row();

                    if(!isset($query->id))
                    {
                        return 'Parent Page not Exist!';
                    }
                }
            
                $data = array(
		    'parent_id'   => $parent,
		    'slug' => $slug,
                    'title' => $title,
		    'content' => $content
		);
            
                
                $this->db->insert('pages', $data);
                
                $id = $this->db->insert_id();
                
                return (isset($id)) ? TRUE : FALSE;
        }
        
        
        
        
}