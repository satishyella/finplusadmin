<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct(){
        parent::__construct();	
			$this->load->model('Admin_model');	
				
    }
	public function index()
	{
		$this->load->view('Admin/signin');
	}
	public function login()
	{
			
		if($this->input->post('user')!=''&&$this->input->post('password')!='' ){
			//check user name and password 
		  // $this->load->library('encrypt');
		  //$this->config->item('salt');
		   //md5($salt.$this->input->post('password'));
			//$ev=$this->encrypt->encode($this->input->post('password'));
			//echo $this->encrypt->decode($ev);
			//exit;
			$result=$this->Admin_model->check_user($this->input->post('user'),$this->input->post('password'));
			
			if(empty($result)){
				
			$this->session->set_flashdata('errmsg', $this->lang->line('username_wrong'));
			redirect('admin/index');
		}
		else{
			
			$token=md5(rand(6,2));	
			$this->session->set_userdata('userid',$result['sno']);
			$this->session->set_userdata('email',$result['email']);
			$this->session->set_userdata('login',$result['login']);
			//$this->session->set_userdata('user_role',$result['user_role']);
			$this->session->set_userdata('token',$token);
		    redirect('admin/dashboard?token='.$token);
		
		}
			
			
			
		}
		else
		{
			redirect('admin/index');
			
		}
		
	}
	public function dashboard()
	{
		if($this->input->get('token')==$this->session->userdata('token')){
		$data['petdetails']=$this->Admin_model->allcompanies();
		$data['page']='admin/dashboard';
		$data['active']='dashboard';
		$this->load->view('admin/finadmin_template',$data);
		}
		else 
		{
			
			$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
			redirect('admin/index');
		}
	
	}
	public function forms()
	{
		if($this->input->get('token')==$this->session->userdata('token')){
		$data['forms']=$this->Admin_model->allforms();
		$data['page']='admin/forms';
		$data['active']='form';
		$this->load->view('admin/finadmin_template',$data);
		}
		else 
		{
			
			$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
			redirect('admin/index');
		}
	
	}
	public function logs()
	{
		if($this->input->get('token')==$this->session->userdata('token')){
			
		$data['logs']=$this->Admin_model->getlogs();
		//exit;
		$data['page']='admin/logs';
		$data['active']='log';
		$this->load->view('admin/finadmin_template',$data);
		}
		else 
		{
			
			$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
			redirect('admin/index');
		}
	
	}
	public function logout()
	{
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('email');//punch in flag
		$this->session->unset_userdata('login');//punch in pinlocation
		$this->session->unset_userdata('token');
		redirect('admin/index');
	}
	public function addcompany(){
		$cik=$this->input->post('cik');
		$firmid=$this->input->post('firmid');
		$cname=$this->input->post('cname');
		$comments=$this->input->post('comments');
		//check ing company
		$check=$this->Admin_model->checkcompany($cik);
		if($check){
			$this->session->set_flashdata('susmsg', $this->lang->line('companyexits'));
				
redirect('admin/dashboard?token='.$this->session->userdata('token'));			
			
		}
		$data=array('cik'=>$cik,'firmid'=>$firmid,'cname'=>$cname,'comments'=>$comments,'status'=>1);
		$res=$this->Admin_model->addcompany($data);
		if($res){
			$this->session->set_flashdata('susmsg', $this->lang->line('Addcompanysuccess'));
				
redirect('admin/dashboard?token='.$this->session->userdata('token'));			
			
		}
		else{
			$this->session->set_flashdata('errmsg', $this->lang->line('Addcompanyerror'));
				
redirect('admin/dashboard?token='.$this->session->userdata('token'));			
		}
		
		
		
	}
	
	
	//url 
	
	public function urlcrawling(){
		$url=$this->input->post('url');
		$this->load->model('Crawler_model');
		$formsArr = array();
		$foloder=explode("/",$url);
		$frmid=0;
		if(isset($foloder['6'])){
			$frmid=$foloder['6'];
		}
    		$forms = $this->Crawler_model->activeForms();
    		foreach ($forms as $form) 
    		{
    			$formsArr[] = $form->form_name;
    		}
           $cronSettings = $this->Crawler_model->cronSettings();
    		$cron_time = $cronSettings->cron_time;
    		$upload_folder = "/".$cronSettings->upload_path;
		
		$check=$this->Crawler_model->user_crawel_url($url,$formsArr,$frmid,$upload_folder);
		if($check){
			
			$this->session->set_flashdata('susmsg', $this->lang->line('crallingsucess'));
		}
		else{
			$this->session->set_flashdata('errmsg', $this->lang->line('datamissing'));
		}
		
			
redirect('admin/logs?token='.$this->session->userdata('token'));			
		
		
		
		
	}
	
	
	public function changepassword(){
		
		if($this->input->get('token')==$this->session->userdata('token')){
			$password=$this->input->post('password');
			$confpassword=$this->input->post('confpassword');
			
			if(!empty($password)&&!empty($confpassword)){
				if($password==$confpassword){
					$res=$this->Admin_model->setnewpassword($password);
					
					if($res){
	            $this->session->set_flashdata('susmsg', $this->lang->line('changepasswordconform'));
				
redirect('admin/changepassword?token='.$this->session->userdata('token'));					
					}
					else{
						$this->session->set_flashdata('errmsg', $this->lang->line('datamissing'));
				redirect('admin/changepassword?token='.$this->session->userdata('token'));	
					}
					
				}
				else{
					$this->session->set_flashdata('errmsg', $this->lang->line('chnagepasswordnotmatch'));
				redirect('admin/changepassword?token='.$this->session->userdata('token'));	
				}
			}
			else{
		$data['page']='admin/passwordchange';
		$this->load->view('admin/finadmin_template',$data);
			}
		}
		else{
		$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
		
			redirect('admin/index');
		}
		
		
	}
	public function settings(){
		
		if($this->input->get('token')==$this->session->userdata('token')){
			
			$data['page']='admin/settings';
			$data['active']='';
			//get latest active record
			$upload_path=$this->input->post('upload_path');
			$crontime=$this->input->post('crontime');
			if(!empty($upload_path)&&!empty($crontime)){
				$newdata=array('upload_path'=>$upload_path,'cron_time'=>$crontime,'status'=>1);
				$res=$this->Admin_model->setnewsettings($newdata);
					
					if($res){
	            $this->session->set_flashdata('susmsg', $this->lang->line('settingssuss'));
				
redirect('admin/settings?token='.$this->session->userdata('token'));					
					}
					else{
						$this->session->set_flashdata('errmsg', $this->lang->line('datamissing'));
				redirect('admin/settings?token='.$this->session->userdata('token'));	
					}
					
			}
			else{
		$data['crontime']=$this->Admin_model->getactivecrontime();
			}
		$this->load->view('admin/finadmin_template',$data);
		}
		else{
		$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
		
			redirect('admin/index');
		}
		
		
	}
	
	 function act_inact_comp($user, $sts,$token) {
        try {
			if($token==$this->session->userdata('token')){
           
            $satus = $this->Admin_model->up_sts_adminuser($user, $sts);
            if ($satus)
                $this->session->set_flashdata('suc_msg', "Company Status changed  Successfully");
            else
                $this->session->set_flashdata('err_msg', "oops ! something went wrong ");
            redirect('admin/dashboard?token='.$this->session->userdata('token'));
			}
			else 
		{
			
			$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
			redirect('admin/index');
		}
        } catch (Exception $e) {
            log_message('error', 'company' . $e->getMessage());
            throw new Exception('Oops! Something went wrong usersmanagement function in Measures Controller  ');
        }
    }
	function act_inact_form($user, $sts,$token) {
        try {
			if($token==$this->session->userdata('token')){
           
            $satus = $this->Admin_model->up_sts_form($user, $sts);
            if ($satus)
                $this->session->set_flashdata('suc_msg', "Form Status changed  Successfully");
            else
                $this->session->set_flashdata('err_msg', "oops ! something went wrong ");
            redirect('admin/forms?token='.$this->session->userdata('token'));
			}
			else 
		{
			
			$this->session->set_flashdata('errmsg', $this->lang->line('invalid_token'));
			redirect('admin/index');
		}
        } catch (Exception $e) {
            log_message('error', 'form ' . $e->getMessage());
            throw new Exception('Oops! Something went wrong usersmanagement function in Measures Controller  ');
        }
    }
	public function forgotpassword(){
		$email=$this->input->post('email');
		//check email id exits or not 
		$result=$this->Admin_model->checkemailid($email);
		
		if(empty($result)){
				
			$this->session->set_flashdata('errmsg', $this->lang->line('emailnotexit'));
			redirect('admin/index');
		}
		else{
			//print_r($result);
			$useid=$result['sno'];
			$res=$this->Admin_model->createnewpassword($useid,$email);
			if($res){
				$this->session->set_flashdata('errmsg', $this->lang->line('emailexit'));
			redirect('admin/index');
			}
			else{
				$this->session->set_flashdata('errmsg', $this->lang->line('datamissing'));
			redirect('admin/index');
			}
		}
		
	}
	
}
