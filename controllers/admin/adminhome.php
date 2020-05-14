<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdminHome extends Controller {	
    
	function AdminHome() {
        parent::Controller();
        
		//Security check please
        $this->freakauth_light->check('admin');
		
    }
	
    function index()
    {
		//Security check please
		$this->freakauth_light->check('admin');
			   
    	$data['title']=$this->lang->line('admin_home');
		$data['action']= $this->lang->line('admin_welcome');
		$data['user'] = $this->db_session->userdata('user_name');
	        
	    $this->load->view('admin/admin_view',$data);    
    }
    
}

?>