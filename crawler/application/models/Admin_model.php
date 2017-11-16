<?php

class Admin_model extends CI_Model {
	public function check_user($user,$password){
		$password=md5($this->config->item('salt').$password);
		
		$query=$this->db->query("select * from admin_users where email='$user' and pswd='$password' and status='1'");
		$data = $query->result_array(); 
				
			
				return $data[0];
		
	
	}
	public function allcompanies(){
		$query=$this->db->query("select * from companies");
		
		$data = $query->result_array(); 
				
			
				return $data;
		
		
	}
	public function allforms(){
		$query=$this->db->query("select * from forms");
		
		$data = $query->result_array(); 
				
			
				return $data;
		
		
	}
	public function getactivecrontime(){
		$query=$this->db->query("select * from cron_settings where status=1 order by sno desc limit 1");
		if(isset($query->result_array()[0]))
		$data = $query->result_array()[0]; 
	else
		$data=array('upload_path'=>'','cron_time'=>'');
				
			
				return $data;
		
		
	}
	public function getlogs(){
		$query=$this->db->query("SELECT * FROM `insiderdocument` order by InsiderDocumentID desc");
		
		$data = $query->result_array(); 
				
			
				return $data;
		
		
	}
	public function setnewsettings($data){
		
		try{
			$data1=array('status'=>0);
		$this->db->where('status', 1);
		
			$this->db->update('cron_settings',$data1);
			return $this->db->insert('cron_settings',$data);
		}
		catch(Exception $e){
			log_message('error', 'Add settings function'.$e->getMessage());
        throw new Exception('Oops! Something went wrong.');
		}
	}
	public function addcompany($data){
		
		try{
			
			return $this->db->insert('companies',$data);
			
		}catch(Exception $e){
		 log_message('error', 'Add Comapny model function'.$e->getMessage());
        throw new Exception('Oops! Something went wrong.');
		}
	
	
	
		
	}
	public function checkcompany($cik){
		
		try{
			$this->db->where('cik',$cik);
			$query=$this->db->get('companies');
			return $query->num_rows();
			
		}catch(Exception $e){
		 log_message('error', 'checkcompany model function'.$e->getMessage());
        throw new Exception('Oops! Something went wrong.');
		}
	
	
	
		
	}
	public function up_sts_adminuser($userid,$status){
		$data=array('status'=>$status);
		$this->db->where('sno', $userid);
		
		return $this->db->update('companies',$data);
		
	}
	public function up_sts_form($userid,$status){
		$data=array('status'=>$status);
		$this->db->where('sno', $userid);
		
		return $this->db->update('forms',$data);
		
	}
	public function setnewpassword($password){
			$password=md5($this->config->item('salt').$password);
		$data=array('pswd'=>$password);
		$this->db->where('sno', $this->session->userdata('userid'));
		return $this->db->update('admin_users',$data);
		
	}
	public function checkemailid($email){
			
		$array = array('email' =>$email);
		$query = $this->db->get_where('admin_users',$array);
      $data=$query->result_array();
		return $data[0];
		
	}
	public function createnewpassword($userid,$email){
			$rand=rand();
		$password=md5($this->config->item('salt').$rand);
		$data = array(
               'pswd' => $password
               
            );

$this->db->where('sno', $userid);
return $this->db->update('admin_users', $data); 
		
	}
}

?>