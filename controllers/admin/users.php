<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Controller {
	
	function Users(){
		parent::Controller();
		//Security check please
		$this->freakauth_light->check('admin');
		
		//loads necessary libraries and models
        $this->lang->load('freakauth');
        $this->load->model('FreakAuth_light/usermodel', 'usermodel');
        if ($this->config->item('FAL_use_country'))
            $this->load->model('country', 'country_model');
        //lets load the validation class if it hasn't been already loaded
        //it is needed by the FAL_validation library
        if ( ! class_exists('CI_Validation'))
		{
		     $this->load->library('validation');
		}
        $this->load->library('FAL_validation', 'fal_validation');
		$this->fal_validation->set_error_delimiters($this->config->item('FAL_error_delimiter_open'), $this->config->item('FAL_error_delimiter_close'));
		$this->load->library('Db_session');
		
	}
	
	function index(){
		//Security check please
		$this->freakauth_light->check('admin');
		
		//title and action
		$data['action']= $this->lang->line('user_configuration');
		$data['title']= $this->lang->line('user_configuration');
		
		//paginate our pages
		$this->load->library('pagination');
		$pagination['base_url']=base_url().$this->config->item('index_page').'/'.'admin/users';
		$pagination['per_page'] = '10';
		$pagination['uri_segment'] = '3';
		if ($this->freakauth_light->isSuperAdmin())
        {
			$total_rows = $this->usermodel->getUsers();
		} else {
			$total_rows = $this->usermodel->getUsersNotSuperadmin();
		}
		$pagination['total_rows'] = $total_rows->num_rows();
		$this->pagination->initialize($pagination);
		
		//limit our result
		$page = $this->uri->segment(3 , 0);
		$limit =array('start'=>$pagination['per_page'],'end'=>$page);
		
		if ($this->freakauth_light->isSuperAdmin())
        {
			$data['query'] = $this->usermodel->getUsers('',$limit,'');	
		} else {
			$data['query'] = $this->usermodel->getUsersNotSuperadmin('',$limit,'');	
		}	
	
		//set validation rules
    	$rules['user_name'] = 'trim|required|xss_clean|username_check|username_backend_duplicate_check';
        $rules['password'] = 'trim|required|xss_clean|password_backend_check';
        $rules['password_confirm'] = "trim|required|xss_clean|matches[password]";
        $rules['email'] = 'trim|required|valid_email|xss_clean|email_backend_duplicate_check';
        $rules['role'] = 'trim|required';
        $rules['banned'] = 'is_numeric';
        
        $this->fal_validation->set_message('is_numeric', 'must be numeric');
        //do we want to set the country?
        //(looks what we set in the freakauth_light.php config)
        if ($this->config->item('FAL_use_country'))
        {
            $rules['country_id'] = $this->config->item('FAL_user_country_field_validation_register');
        }
		
		//getting user profile custom data
	    if ($this->config->item('FAL_create_user_profile')==TRUE)
		{	
		    $userprofiledata = $this->freakauth_light->_buildUserProfileFieldsRules();
		    $data['rules'] = $userprofiledata['rules'];
		    $data['fields'] = $userprofiledata['fields']; 
		    
		    $this->fal_validation->set_rules($data['rules']);
		    	
		    $this->fal_validation->set_fields($data['fields']);
		}
             
        $this->fal_validation->set_rules($rules);
		
		//sets the necessary form fields
		$fields['user_name'] = '"'.$this->lang->line('user_configuration_username').'"';
        $fields['password'] = '"'.$this->lang->line('user_configuration_password').'"';
        $fields['password_confirm'] = '"'.$this->lang->line('user_configuration_retypepassword').'"';
        $fields['email'] = '"'.$this->lang->line('user_configuration_email').'"';
        $fields['role'] = '"'.$this->lang->line('user_configuration_role').'"';
        $fields['banned'] = '"'.$this->lang->line('user_configuration_banned').'"';
        
        //if activated in config, sets the select country box
        if ($this->config->item('FAL_use_country'))
        {
            $fields['country_id'] = $this->lang->line('FAL_user_country_label');
        }
        
        //additionalFields($fields);
        
        $this->fal_validation->set_fields($fields);
		
		 $data['role_options'] = $this->_getRoleOptions();
		
		if($this->fal_validation->run() == FALSE)
		{	
			$this->load->view('admin/users/users_view',$data);
		}
		else 
		{
			$values=$this->_get_form_values();
			
        	//insert data in DB
        	$this->usermodel->insertUser($values['user']);
        	
        	//if we want the user profile as well
	        if($this->config->item('FAL_create_user_profile'))
	        {	
	              //let's get the last insert id
	              $values['user_profile']['id']= $this->db->insert_id();
	              $this->load->model('Userprofile');
	              $this->Userprofile->insertUserProfile($values['user_profile']);
	        }
			flashMsg($this->lang->line('FLA_Users_added_successfully'));
			redirect('admin/users');
		}
		
		
	}
	
	function delete($id)
    {
        // security check:
        // admins or superadmins cannot be deleted in the users controller
        $edited_role = getUserPropertyFromId($id, 'role');
		if ($this->freakauth_light->isSuperAdmin())
        {
			$allowed = TRUE;
		} else {
       		$allowed = ($edited_role != 'superadmin');
		}
        if (!$allowed) {
			$this->freakauth_light->denyAccess(getUserProperty('role'));
		} else {
			$this->usermodel->deleteUser($id);
			
			if ($this->config->item('FAL_create_user_profile')==TRUE)
			{
				$this->load->model('Userprofile');
				$this->Userprofile->deleteUserProfile($id);
			}
			flashMsg($this->lang->line('FLA_Users_deleted_successfully'));
			
			redirect('admin/users');
		}
	        
    }
	
	function search(){
		//Security check please		
		$this->freakauth_light->check('admin');
		
		//title and action
		$data['title']=$this->lang->line('user_configuration_search');
		$data['action']=$this->lang->line('user_configuration_search');
		
		//store the keyword to session
		$this->load->library('Db_session');
		if(isset($_POST['search']))
			$this->db_session->set_userdata('search',$_POST['search']);
		if(isset($_POST['typesearch']))
			$this->db_session->set_userdata('typesearch',$_POST['typesearch']);
		
		//paginate our pages
		$this->load->library('pagination');
		$pagination['base_url']=base_url().$this->config->item('index_page').'/'.'admin/users/search';
		$pagination['per_page'] = '10';
		$pagination['uri_segment'] = '4';
		$total_rows = $this->usermodel->searchUser('',$this->freakauth_light->isSuperAdmin());
		$pagination['total_rows'] = $total_rows->num_rows();
		$this->pagination->initialize($pagination);
		
		//limit our result
		$page = $this->uri->segment(4 , 0);
		$limit =array('start'=>$pagination['per_page'],'end'=>$page);
		
		$data['query'] = $this->usermodel->searchUser($limit,$this->freakauth_light->isSuperAdmin());	

		$this->load->view('admin/users/users_search',$data);
		
	}
	
	function _get_form_values()
    {
        if (isset($_POST['id'])) 
        {
        	//for edit record
        	$values['user']['id']=$_POST['id']; 
        }

        $values['user']['user_name'] = $this->input->post('user_name', TRUE);
        $values['user']['password'] = $this->input->post('password');
        $values['user']['email'] = $this->input->post('email');
        $values['user']['country_id'] = $this->input->post('country_id');
		$values['user']['banned'] = $this->input->post('banned');
		$values['user']['role'] = $this->input->post('role');
		
		//let's get the custom user profile  values
		if ($this->config->item('FAL_create_user_profile')==TRUE)
		{	
		    $this->load->model('Userprofile', 'userprofile');
		    
		    //array of fields
  			$db_fields=$this->userprofile->getTableFields();

  			//number of DB fields -1
  			//I put a -1 because I must subtract the 'id' field
  			$num_db_fields=count($db_fields) - 1;
  		
  			//I use 'for' instead of 'foreach' because I have to escape the 'id' field that has key=0 in my array
	  		for ($i=1; $i<=$num_db_fields;  $i++)
			{
				$values['user_profile'][$db_fields[$i]]=$this->input->post($db_fields[$i]);
			}
		 }
		
        //let's treat our banned yes/no checkbox
        if (isset($_POST['banned']) AND $_POST['banned'] =='') 
        {
        	//let's assign value zero (not banned)
        	$values['user']['banned']=0; 
        }

        if (($values['user']['user_name'] != false) && ($values['user']['email'] != false))
        {
            //necessary if password is not reset in edit()
        	if ($values['user']['password'] !='')  
            {
	        	$password = $values['user']['password'];
	        	//encrypts the password (md5)
	        	$values['user']['password'] = $this->freakauth_light->_encode($password);
            }
            else 
            {
            	unset($values['user']['password']);
            }

        	return $values;
        }
        
        return false;
    }

    function _getRoleOptions()
    {
        $roles = array_keys($this->config->item('FAL_roles'));
        
        // if the user is a superadmin,
        // let him the ability to give superadmin or admin roles
        if (!$this->freakauth_light->isSuperAdmin())
        {
            unset($roles[0]);
        }
		
		return $roles;
		
    }
}
?>