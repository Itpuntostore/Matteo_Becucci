<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

Class Eventimodel extends model {
	function Eventimodel(){
		parent::Model();
		
	//table name
	$this->_table= 'eventi';
	}
	
	function getEventi($fields = null, $where = null, $limit = null, $order = null){
		($fields != null) ? $this->db->select($fields) :'';
		
		($where != null) ? $this->db->where($where) :'';
		
		($limit != null) ? $this->db->limit($limit['start'],$limit['end']) :'';

		$this->db->order_by('date','desc');
		
		return $this->db->get($this->_table);
	}
	
	
	function deleteEvento(){
		//Start transaction
		$this->db->trans_start();
					
		//delete table
		$this->db->where('id',$this->uri->segment(3));
		$this->db->delete($this->_table);
				
		//OK stops here   
		
		$this->db->trans_complete();
	}
	
	function editEvento(){
		//Start transaction
		$this->db->trans_start();
		
		$dateevento=explode("/",$_POST['date']);
		$date=$dateevento[2]."/".$dateevento[1]."/".$dateevento[0];
		$titleit=htmlspecialchars(stripslashes($_POST['titleit']));
		$titleen=htmlspecialchars(stripslashes($_POST['titleen']));
		$descriptionit=htmlspecialchars(stripslashes($_POST['descit']));
		$descriptionen=htmlspecialchars(stripslashes($_POST['descen']));
	if($_POST['link']=="" || $_POST['link']=="#") {
			$link='#';
		} else {
			if(!strstr($_POST['link'],'http://') && !strstr($_POST['link'],'https://')) {
				$_POST['link']="http://".$_POST['link'];
			}
			$link=htmlspecialchars(stripslashes($_POST['link']));
		}
		$email=htmlspecialchars(stripslashes($_POST['email']));
		$enable=$_POST['enable'];
		
		$evento = array('date'=>$date,'title_it'=>$titleit,'title_en'=>$titleen,'description_it'=>$descriptionit,'description_en'=>$descriptionen,'link'=>$link,'email'=>$email,'enable'=>$enable);
		$this->db->where('id',$_POST['id']);
		$this->db->update($this->_table,$evento);
		
		
		$this->db->trans_complete();
	}
	
	
	function generateEvento($image){
		
		$dateevento=explode("/",$_POST['date']);
		$date=$dateevento[2]."/".$dateevento[1]."/".$dateevento[0];
		$titleit=htmlspecialchars(stripslashes($_POST['titleit']));
		$titleen=htmlspecialchars(stripslashes($_POST['titleen']));
		$descriptionit=htmlspecialchars(stripslashes($_POST['descit']));
		$descriptionen=htmlspecialchars(stripslashes($_POST['descen']));
		if($_POST['link']=="") {
			$link='#';
		} else {
			if(!strstr($_POST['link'],'http://') && !strstr($_POST['link'],'https://')) {
				$_POST['link']="http://".$_POST['link'];
			}
			$link=htmlspecialchars(stripslashes($_POST['link']));
		}
		$email=htmlspecialchars(stripslashes($_POST['email']));
		$enable=$_POST['enable'];
		
		$this->db->trans_start();
		
		$evento = array('date'=>$date,'title_it'=>$titleit,'title_en'=>$titleen,'description_it'=>$descriptionit,'description_en'=>$descriptionen,'link'=>$link,'image'=>$image,'email'=>$email,'enable'=>$enable);
		$this->db->insert($this->_table,$evento);
		
		$this->db->trans_complete();
		
	}
	
	function searchEventi($limit = null){
		//search by username or realname
		$this->db->like($this->db_session->userdata('typesearch'),$this->db_session->userdata('search'));
		
		//limit
		($limit !=null ) ? $this->db->limit($limit['start'],$limit['end']) :'';
		//order
		$this->db->order_by('date','desc');
		
		return $this->db->get($this->_table);
	
	}
	
function getAutoIncrementEventi(){
		
		$evento = $this->db->query("SELECT `AUTO_INCREMENT` AS idmax FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'Sql548105_1' AND TABLE_NAME = '".$this->_table."'");
		
		$evento = $evento->row();
		return $evento->idmax;
	
	}
	
}
?>