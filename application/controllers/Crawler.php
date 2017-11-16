<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crawler extends CI_Controller {

	function __construct(){
        parent::__construct();	
		//$this->load->model('Admin_model');	
		$this->load->model('Crawler_model');			
    }

    public function run_job()
    {
    	try
    	{
    		// To get cron settings
    		$cronSettings = $this->Crawler_model->cronSettings();
    		$cron_time = $cronSettings->cron_time;
    		$upload_folder = "/".$cronSettings->upload_path;
    					
    		// Get active forms to crawel
    		$formsArr = array();
    		$forms = $this->Crawler_model->activeForms();
    		foreach ($forms as $form) 
    		{
    			$formsArr[] = $form->form_name;
    		}

    		// Get active companies and crawel each company    		
    		$companies = $this->Crawler_model->activeCompanies();
    		if(count($companies))
    		foreach ($companies as $company) 
    		{
    			$temp_cik = $company->cik;
    			if(!empty($temp_cik))
    				$this->Crawler_model->crawel_url($temp_cik, $formsArr, $cron_time, $upload_folder);
    		}    		
    	}
    	catch(Exception $e)
    	{
			log_message('error', 'Crawler Controller : run_job function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}
    }
}