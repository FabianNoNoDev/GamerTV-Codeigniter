<?php

class Acp extends MY_Controller {

	 public function __construct()
        {
                parent::__construct();
		$this->load->helper(array('url','language'));
                $this->load->library(array('ion_auth','form_validation'));
                $this->load->model('Acp_model');
                $this->load->model('Pages_model');
                $this->load->model('Top_model');
                $this->load->model('Stream_model');
                $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
                $this->lang->load('auth');
                $this->load->database();
                
                if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}   
                
                $this->data['user'] = json_decode(json_encode($this->ion_auth->user()->row()),true); 
                $this->data['debug'] = '';    
                $this->data['title'] = 'Admin Panel';
        }
    
    
        public function index()
        {
        
            $this->data['community'] = $this->Top_model->get_community();
            
            $this->data['gametop'] = $this->Top_model->get_games();
            
            $this->data['videostop'] = $this->Top_model->get_videos();
            
            $this->data['partnertop'] = $this->Top_model->get_partners();
            
            $this->data['daily_updates'] = $this->Top_model->get_views_day();
            
            // Server Load
            $sys_load = sys_getloadavg();
            $this->data['load'] = $sys_load[0];
            
        $this->load->view('templates/acp_header', $this->data);
        $this->load->view('acp/acp_index', $this->data);
        $this->load->view('templates/acp_footer');
        }
        


        public function twitch()
        {
            
            if($this->input->post('ban'))
               {  
                    $title = $this->input->post('title');
                    $this->form_validation->set_rules('title','Ban name','required|is_unique[banned.ban_name]');
                    
                    
                    if ($this->form_validation->run() == true && $this->Stream_model->twitch_ban($title))
                    {
                      //redirect("acp/twitch/", 'refresh');
                    }  
               }
               
            if($this->input->post('add'))
               {  
                    $title = $this->input->post('title');
                    $this->form_validation->set_rules('title','Twitch Channel','required|is_unique[stream_list.name]');
                    
                    if ($this->form_validation->run() == true && $this->Stream_model->twitch_add($title))
                    {
                      //redirect("acp/twitch/", 'refresh');
                    }  
               }   
               
            if($this->input->post('group_add'))
               {  
                    $title = $this->input->post('group_title');
                    $this->form_validation->set_rules('group_title','Twitch Group','required|is_unique[stream_group.name]');
                    
                    if ($this->form_validation->run() == true && $this->Stream_model->twitch_group($title))
                    {
                      //redirect("acp/twitch/", 'refresh');
                    }  
               }   
            
            $this->data['twitch_title'] = array(
                            'name'  => 'title',
                            'id'    => 'title',
                            'class' => 'form-control',
                            'type'  => 'text'
                        );
            
            $this->data['group_title'] = array(
                            'name'  => 'group_title',
                            'id'    => 'group_title',
                            'class' => 'form-control',
                            'type'  => 'text'
                        );
            
            $this->data['submit'] = array(
                         'name'        => 'add',
                         'id'          => 'add',
                         'class' => 'btn btn-default',   
                     'value' => 'Add Channel',
                     );
            
             $this->data['group_submit'] = array(
                         'name'        => 'group_add',
                         'id'          => 'group_add',
                         'class' => 'btn btn-default',   
                     'value' => 'Add Twitch Group',
                     );
            
            $this->data['ban'] = array(
                         'name'        => 'ban',
                         'id'          => 'ban',
                         'class' => 'btn btn-danger',   
                     'value' => 'Ban Channel',
                     );
            
               
            $this->load->view('templates/acp_header', $this->data);
            $this->load->view('acp/twitch', $this->data);
            $this->load->view('templates/acp_footer');   
        }        
        
        
        
        
        
        public function page_manager($slug = "")
            {

                    if($this->input->post('create'))
                            {    
                                $this->form_validation->set_rules('slug','Slug','required|is_unique[pages.slug]');
                                $this->form_validation->set_rules('title','Title','required');
                                $this->form_validation->set_rules('content','Content','required'); 

                                if($this->input->post('parent')!="")
                                    {
                                      $parent = $this->input->post('parent');
                                    }
                                else
                                    {
                                      $parent=0;
                                    }

                                $title = $this->input->post('title');
                                $content = $this->input->post('content'); 
                                $slug = $this->input->post('slug');

                                 if ($this->form_validation->run() == true && $this->Acp_model->add_page($parent,$slug,$title,$content))
                                 {
                                   redirect("acp/page_manager/", 'refresh');
                                 }  
                                
                            }        
                    elseif($this->input->post('edit'))
                        {
                                    $this->form_validation->set_rules('title','Title','required');
                                    $this->form_validation->set_rules('content','Content','required'); 

                                    if($this->input->post('parent')!="")
                                        {
                                          $parent = $this->input->post('parent');
                                        }
                                    else
                                        {
                                          $parent=0;
                                        }

                                    $title = $this->input->post('title');
                                    $content = $this->input->post('content');
                                    $slug = $this->input->post('slug');

                                     if ($this->form_validation->run() == true && $this->Acp_model->edit_page($parent,$slug,$title,$content))
                                     {
                                       redirect("acp/page_manager/".$slug."", 'refresh');
                                     }                  
                        }
                    else
                    {
                         
                      if($slug != "") // Edit Page
                        {
                          $query = $this->Pages_model->get_page_data($slug);
            
                          $page_id = intval($query['id']);
                          
                          $parent_id = intval($query['parent_id']);
                          
                          $this->data['default_parent'] = array ('Default Select' => $parent_id);
                          
                          $title = $query['title'];
                          
                          $content = $query['content'];
                          
                            $this->data['submit'] = array(
                                'name'        => 'edit',
                                'id'          => 'edit',
                                'class' => 'btn btn-default',   
                            'value' => 'Save Page',
                            );  
                          
                        }
                       else // New Page
                       {
                           
                           $title= "";
                           $slug= "";
                           $content="";
                           
                            $this->data['submit'] = array(
                                    'name'        => 'create',
                                    'id'          => 'create',
                                    'class' => 'btn btn-default',   
                                'value' => 'Create New Page',
                            );  
                        
                            $this->data['default_parent'] = array ('Default Select' => '');  
                       }     
                        
                        $this->data['parent_pages_array'] = $this->Acp_model->parent_pages();
                          
                    
                      
                        $this->data['parent_pages'] = array(
                            'name'  => 'parent',
                            'id'    => 'parent',
                            'class' => 'form-control',
                            'type'  => 'select'
                        );
                        
                        
                        $this->data['page_title'] = array(
                            'name'  => 'title',
                            'id'    => 'title',
                            'class' => 'form-control',
                            'type'  => 'text',
                            'value' => $title,
                        );
                        
                        $this->data['slug'] = array(
                            'name'  => 'slug',
                            'id'    => 'slug',
                            'class' => 'form-control',
                            'type'  => 'text',
                            'value' => $slug,
                        );
                        
                        $this->data['content'] = array(
                                'name'        => 'content',
                                'id'          => 'page_content',
                                'class' => 'form-control',   
                            'value' => $content,
                        );
                      
                        $this->load->view('templates/acp_header', $this->data);
                        $this->load->view('acp/page_manager', $this->data);
                        $this->load->view('templates/acp_footer');
                        
                    }
    }
        

        
}