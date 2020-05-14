<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Controller {
	
	function Home(){
		parent::Controller();	
	}
	
	function index(){
		//Security check please	
		$this->freakauth_light->check('user');
		
		//title and action
		$data['title']=$this->lang->line('home');
		$data['action']= $this->lang->line('home_welcome');
		$data['user'] = $this->db_session->userdata('user_name');
		
		
		$this->load->view('home/home_view',$data);
	}
}
?>