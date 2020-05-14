<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Eventi extends Controller {
	
	function Eventi(){
		parent::Controller();
		//load models and libraries
		$this->load->model('eventimodel');
		$this->load->library('form_validation');
		$this->load->library('validation');
		$this->load->library('pagination');
	}
	
	function index(){
		//Security check please
		$this->freakauth_light->check('user');
		
		//title and action	
		$data['action'] = $this->lang->line('eventi_management');
		$data['title'] = $this->lang->line('eventi_management');
		
		//lets paginate our eventi
		$pagination['base_url']=base_url().$this->config->item('index_page').'/'.'eventi';
		$pagination['per_page'] = '10';
		$pagination['uri_segment'] = '2';
		$total_rows = $this->eventimodel->getEventi("");
		$pagination['total_rows'] = $total_rows->num_rows();
		$this->pagination->initialize($pagination);
		$data['pagination_links'] = $this->pagination->create_links();
		
		//limiting our result
		$page = $this->uri->segment(2, 0);
		$limit = array('start'=>$pagination['per_page'],'end'=>$page);
		$data['eventi']=$this->eventimodel->getEventi("",NULL,$limit);
		
		//Rules for vouchers eventi
		$rules['date'] = 'required|valid_italian_date';
		$rules['titleit']='required';
		$rules['titleen'] = 'required';
		$rules['descit'] = 'required';
		$rules['descen']='required';
		$this->validation->set_rules($rules);
		$fields['date'] = $this->lang->line('eventi_date');
		$fields['titleit'] = $this->lang->line('eventi_titleit');
		$fields['titleen'] = $this->lang->line('eventi_titleen');
		$fields['descit'] = $this->lang->line('eventi_descriptionit');
		$fields['descen'] = $this->lang->line('eventi_descriptionen');
		$this->validation->set_fields($fields);
		
		//$this->output->enable_profiler(TRUE);
		if($this->validation->run()==false){	
			$this->load->view('eventi/eventi_view',$data);
		}else{
				
			if(isset($_FILES["image_upload_box"]["name"]) && $_FILES["image_upload_box"]["name"]!="") {
				
				log_message('error',"eccomi");
					
					$idevento=$this->eventimodel->getAutoIncrementEventi();
					$immagine="";
					$file_extension= substr($_FILES["image_upload_box"]["name"],strpos($_FILES["image_upload_box"]["name"], '.'));
					$immagine="../assets/img/eventi/image_".$idevento.$file_extension;
					
					// file needs to be jpg,gif,bmp,x-png and 4 MB max
					if (($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg" || $_FILES["image_upload_box"]["type"] == "image/gif" || $_FILES["image_upload_box"]["type"] == "image/x-png") && ($_FILES["image_upload_box"]["size"] < 4000000))
					{
						// some settings
						$max_upload_width = 2600;
						$max_upload_height = 2600;
						$max_width_box = 250;
						$max_height_box = 250;
						
						// if user chosed properly then scale down the image according to user preferances
						if(isset($max_width_box) and $max_width_box!='' and $max_width_box<=$max_upload_width){
							$max_upload_width = $max_width_box;
						}    
						if(isset($max_height_box) and $max_height_box!='' and $max_height_box<=$max_upload_height){
							$max_upload_height = $max_height_box;
						}	
						// if uploaded image was JPG/JPEG
						if($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg"){	
							$image_source = imagecreatefromjpeg($_FILES["image_upload_box"]["tmp_name"]);
							$type="jpeg";
						}		
						// if uploaded image was GIF
						if($_FILES["image_upload_box"]["type"] == "image/gif"){	
							$image_source = imagecreatefromgif($_FILES["image_upload_box"]["tmp_name"]);
						}	
						// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
						// if uploaded image was BMP
						if($_FILES["image_upload_box"]["type"] == "image/bmp"){	
							$image_source = imagecreatefromwbmp($_FILES["image_upload_box"]["tmp_name"]);
						}			
						// if uploaded image was PNG
						if($_FILES["image_upload_box"]["type"] == "image/x-png"){
							$image_source = imagecreatefrompng($_FILES["image_upload_box"]["tmp_name"]);
						}
						$remote_file = $this->config->item('ABSOLUTE_SERVER_PATH_IMAGES')."image_".$idevento.$file_extension;
						imagejpeg($image_source,$remote_file,100);
						chmod($remote_file,0644);
						// get width and height of original image
						list($image_width, $image_height) = getimagesize($remote_file);
						if($image_width>$max_upload_width || $image_height >$max_upload_height){
							$proportions = $image_width/$image_height;
							if($image_width>$image_height){
								$new_width = $max_upload_width;
								$new_height = round($max_upload_width/$proportions);
							}		
							else{
								$new_height = $max_upload_height;
								$new_width = round($max_upload_height*$proportions);
							}							
							$new_image = imagecreatetruecolor($new_width , $new_height);
							$image_source = imagecreatefromjpeg($remote_file);			
							imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
							imagejpeg($new_image,$remote_file,100);			
							imagedestroy($new_image);
						}		
						imagedestroy($image_source);	

						$this->eventimodel->generateEvento($immagine);
						
						flashMsg($this->lang->line('FLA_Evento_created_successfully'));
						redirect('eventi');	
					
					}
			}
				
			$data['errore']=$this->lang->line('eventi_erroreformato');
			$this->load->view('eventi/eventi_view',$data);
		}	
	}
	
	function delete(){
		//security check
		$this->freakauth_light->check('user');
		
		$this->load->model('eventimodel');
		
		//get current data
		if(isset($_POST['id']) && $_POST['id']!='') {
			$where = array('id'=>$_POST['id']);
		} else {
			$where = array('id'=>$this->uri->segment(3));
		}
		$resultEvento = $this->eventimodel->getEventi('',$where,'');
		$evento=$resultEvento->row();
		$this->eventimodel->deleteEvento();
		unlink($this->config->item('ABSOLUTE_SERVER_PATH_IMAGES').substr($evento->image,21));
		
		flashMsg($this->lang->line('FLA_Evento_deleted_successfully'));
		
		redirect('eventi','location');
	}
	
	function edit(){
		//security check
		$this->freakauth_light->check('user');
		
		//title and action
		$data['title']= $this->lang->line('eventi_management');
		$data['action']= $this->lang->line('eventi_edit');
		
		//set rules for the fields
		$rules['date'] = 'required valid_italian_date';
		$rules['titleit']='required';
		$rules['titleen'] = 'required';
		$rules['descit'] = 'required';
		$rules['descen']='required';
		$this->validation->set_rules($rules);
		$fields['date'] = $this->lang->line('eventi_date');
		$fields['titleit'] = $this->lang->line('eventi_titleit');
		$fields['titleen'] = $this->lang->line('eventi_titleen');
		$fields['descit'] = $this->lang->line('eventi_descriptionit');
		$fields['descen'] = $this->lang->line('eventi_descriptionen');
		$this->validation->set_fields($fields);
		
		//get current data
		if(isset($_POST['id']) && $_POST['id']!='') {
			$where = array('id'=>$_POST['id']);
		} else {
			$where = array('id'=>$this->uri->segment(3));
		}
		$data['evento'] = $this->eventimodel->getEventi('',$where,'');
		
		if($this->validation->run() == FALSE){
			$this->load->view('eventi/eventi_edit', $data);
		}else{
			$this->eventimodel->editEvento();
			flashMsg($this->lang->line('FLA_Evento_modified_successfully'));
			redirect('eventi');
		}
	}
	
	function search(){
		//Security check please		
		$this->freakauth_light->check('user');
		
		//title and action
		$data['title']=$this->lang->line('eventi_search_result');
		$data['action']=$this->lang->line('eventi_search_result');
		
		//store the keyword to session
		$this->load->library('Db_session');
		if(isset($_POST['search']))
			$this->db_session->set_userdata('search',$_POST['search']);
		if(isset($_POST['typesearch']))
			$this->db_session->set_userdata('typesearch',$_POST['typesearch']);
		
		//paginate our pages
		$this->load->library('pagination');
		$pagination['base_url']=base_url().$this->config->item('index_page').'/'.'eventi/search';
		$pagination['per_page'] = '10';
		$pagination['uri_segment'] = '3';
		$total_rows = $this->eventimodel->searchEventi();
		$pagination['total_rows'] = $total_rows->num_rows();
		$this->pagination->initialize($pagination);
		
		//limit our result
		$page = $this->uri->segment(3, 0);
		$limit =array('start'=>$pagination['per_page'],'end'=>$page);
		$data['eventi']=$this->eventimodel->searchEventi($limit);

		$this->load->view('eventi/eventi_search',$data);
	}
	
}
?>