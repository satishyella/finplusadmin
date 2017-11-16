<?php
class Crawler_model extends CI_Model 
{
	protected $tempArr;
	protected $upload_folder;
	function __construct(){
		$tempArr = array();
		$upload_folder='';
	}
	
	public function activeCompanies()
	{
		try
    	{
    		$this->db->select('cik, firmid, cname');
    		$this->db->where('status','1');
    		$this->db->where('cik != ','');
			$query = $this->db->get('companies');

			if($query->num_rows() > 0)
			{
				return $query->result();
			} 
			else
			{
				return array();
			}

	   	}
    	catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : activeCompanies function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}		
	}

	public function activeForms()
	{
		try
    	{
    		$this->db->select('form_name');
    		$this->db->where('status','1');
			$query = $this->db->get('forms');

			if($query->num_rows() > 0)
			{
				return $query->result();
			} 
			else
			{
				return array();
			}

	   	}
    	catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : activeForms function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}		
	}

	public function cronSettings()
	{
		try
    	{
    		$this->db->select('upload_path, cron_time');
    		$this->db->where('status','1');
    		$this->db->order_by('sno','desc');
    		$this->db->limit('1');
			$query = $this->db->get('cron_settings');

			if($query->num_rows() > 0)
			{
				return $query->result()[0];
			} 
			else
			{
				return array();
			}
	   	}
    	catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : cronSettings function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}		
	}
	
	public function crawel_url($firmid, $formsArr, $cron_time, $upload_folder )
    {
		try
		{		
            $this->upload_folder=$upload_folder;		
			$ctime = date('Y-m-d H:i:s');
			$mtime = date('Y-m-d H:i:s');			
			$cron_date = date('Y-m-d', strtotime( '-10 days' ));
			
			$url="https://www.sec.gov/Archives/edgar/data/".$firmid;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result=curl_exec($ch);
			curl_close($ch);
			$returned_content = $result;
			
			$first_step = explode( '<table summary="Directory Listing for $full_dir">' , $returned_content);
			$second_step = explode('</table>', $first_step[1]);	
			$third_step = explode('<tr>', $second_step[0]);

			$i=0;
			foreach ($third_step as $key=>$element) 
			{
				/*if( strpos($element, $cron_date) === false)
				{ }
				else*/
				{
					$i++;
					$child_first = explode( '</a>', $element );
					if(isset($child_first[1]))
					{
						$content = preg_replace("/<img[^>]+\>/i", "",  $child_first[0]);					
						$trgeturl= $url."/".strip_tags($content);
						$data=file_get_contents($url."/".strip_tags($content));

						$pagelevel = explode( '<table summary="Directory Listing for $full_dir">' , $data);
						$pagelevl_step2 = explode('</table>', $pagelevel[1]);
						$pagethird_step = explode('<tr>', $pagelevl_step2[0]);

						foreach ($pagethird_step as $key1=>$element1) 
						{	
							$child_first2 = explode( '</a>', $element1 );	
							if(isset($child_first2[1]))
							{
								$content1 = preg_replace("/<img[^>]+\>/i", "",  $child_first2[0]);
								$filename=strip_tags($content1);

								if(strtolower(substr($filename, strrpos($filename, '.') + 1)) == 'xml' )
								{
									$xmlurl = $trgeturl."/".$filename;
									$xml = simplexml_load_file($xmlurl);
									
									// Insert into main table and get main fk start									
									$fk_id = $this->insiderdocumentData($xmlurl, $firmid, $xml, $formsArr, $cron_time);
									
									if($fk_id)
									{
										// Insert ownership data into owner table
										$this->insiderrepownerData($xml->reportingOwner, $fk_id);
										
										// Insert derivative and non-derivative data into transaction table
										$dervArr = $this->insidertransactionData($xml->derivativeTable, $fk_id, 'derivativeTable_');
										if(count($dervArr)) {
											$this->db->insert_batch('insidertransaction', $dervArr);
										}										
										$nondervArr = $this->insidertransactionData($xml->nonDerivativeTable, $fk_id, 'nonDerivativeTable_');
										if(count($nondervArr)) {
											$this->db->insert_batch('insidertransaction', $nondervArr);
										}	
										
										// Insert footnotes data into footnotes table										
										$fnotes=$this->insiderfnData($xml->footnotes, $fk_id, $xml);
										if(count($fnotes)) {
											$this->db->insert_batch('insiderfn', $fnotes);
										}
										//update success Status 
										$staus=array('curl_status'=>1);
										$this->db->where('InsiderDocumentID',$fk_id);
										$this->db->update('insiderdocument',$staus);
									
									}
								}
							}
						}
					}
				}					
			}
		}
    	catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : crawel_url function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}	
    }	
	
	public function insiderdocumentData($xmlurl, $firmid, $xml, $formsArr, $cron_time)
	{
		try
		{			
			$ctime = date('Y-m-d H:i:s');
			$mtime = date('Y-m-d H:i:s');
			
			if( in_array($xml->documentType, $formsArr) )
			{
				$schemaVersion = $xml->schemaVersion;
				$documentType =  $xml->documentType;
				$periodOfReport = $xml->periodOfReport;
				$notSubjectToSection16 = $xml->notSubjectToSection16;

				foreach($xml->issuer as $issuer){
					$issuerCik = $issuer->issuerCik;
					$issuerName = $issuer->issuerName;
					$issuerTradingSymbol = $issuer->issuerTradingSymbol;		
				}

				$remarks = '';
				if(isset($xml->remarks))
				foreach($xml->remarks as $remarks_value)
					$remarks = $remarks_value;

				$CurrencyID = '';
				if($xml->CurrencyID) 
					$CurrencyID = $xml->CurrencyID;
				//update past records
       $this->db->where('Document_Path',$xmlurl);
     $this->db->update('insiderdocument',array('status'=>0));
	$local_path='';
	 //store in loocal path
	$foloder=explode("/",$xmlurl);
	if(isset($foloder[6])){
		$local_path=$this->upload_folder."/".$foloder[6]."/";
		
	@mkdir(".".$local_path, 0755,true);

	}
	// $copyurl=$local_path
	$documentType1=str_replace('/',"_",$documentType);
	$filename=$local_path.$firmid."_".$foloder[7]."_".$documentType1."_".date('Y-m-d')."_".$periodOfReport.".xml";
	
	 @copy($xmlurl,$this->config->item('base_path').$filename);
				$main_data = array(
					'FirmID' => $firmid, 
					'CurrencyID' => $CurrencyID, 
					'Document_Path' => $xmlurl,
                    'local_path'=>$filename,					
					'schemaVersion' => $schemaVersion, 
					'documentType' => $documentType, 
					'periodOfReport' => $periodOfReport, 
					'issuerCik' => $issuerCik, 
					'issuerName' => $issuerName, 
					'issuerTradingSymbol' => $issuerTradingSymbol, 
					'remarks' => $remarks, 
					'ctime' => $ctime, 
					'mtime' => $mtime, 
					'cron_time' => $cron_time
				);

				$this->db->insert('insiderdocument', $main_data);
				$fk_id = $this->db->insert_id();
				return $fk_id;
		}
		}
		catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : insiderdocumentData function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}	
	}
	
	public function insiderrepownerData($input_xml, $fk_id)
	{
		try
		{
			$insiderrepowner = array();									
			$isrp = 0;
			
			foreach($input_xml as $reportingOwner)
			{
				$reportingOwnerArr = (array) $reportingOwner;
				foreach($reportingOwnerArr as $temp_sufix => $kObj)
				{
					$kArr = (array) $kObj;
					foreach($kArr as $key => $val)
					{
						$insiderrepowner[$isrp]['InsiderDocumentID_fk'] = $fk_id;
						$insiderrepowner[$isrp]['MainTag'] = 'reportingOwner_'.$temp_sufix;
						$insiderrepowner[$isrp]['XMLTag'] = $key;	
						$insiderrepowner[$isrp]['TagValue'] = $val;	
						$isrp++;
					}
				}										
			}
			if($isrp > 0) {
				$this->db->insert_batch('insiderrepowner', $insiderrepowner);
			}
		}
		catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : insiderrepownerData function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}	
	}
	
	public function RecurseXML($fk_id, $DocLineNo, $MainTag, $xml, $parent="") 
	{ 
		$child_count = 0; 
		foreach($xml as $key=>$value) 
		{ 
	      	$child_count++;     
	      	if($this->RecurseXML($fk_id, $DocLineNo, $MainTag, $value, $parent."_".$key) == 0)  // no childern, aka "leaf node" 
	      	{ 
	        	//print($parent . "_" . (string)$key . " = " . (string)$value . "<BR>\n");  
				if($key=='footnoteId'){
					foreach($xml->footnoteId->attributes() as $a=>$b);
					$b=(array)$b;
					if(isset($b[0]))
					$value=$b[0];
					
				}
				
	        	$this->tempArr[]= array('InsiderDocumentID_fk' => $fk_id, 
	        							'DocLineNo' => $DocLineNo, 
	        							'MainTag' => $MainTag, 
	        							'XMLTag' => substr($parent . "_" . (string)$key,1), 
	        							'TagValue' => (string)$value 
	        							);	        		
	      	}     
	   	} 
	   	return $child_count; 
	} 
	
	public function insidertransactionData($input_xml, $fk_id, $sufType)
	{
		try
		{
			$insidertransaction = array();
			$DocLineNo = 0;
			foreach($input_xml as $ndtableMain)
			{
				if(gettype($ndtableMain) == 'object')
					$ndtableMain = (array) $ndtableMain;

				foreach ($ndtableMain as $mainKey => $ndtblEach) 
				{				
					if(gettype($ndtblEach) == 'object')
						$ndtblEach = (array) $ndtblEach;

					foreach ($ndtblEach as $firstKey => $firstVal) 
					{	
						$DocLineNo++; 
						$this->RecurseXML($fk_id, $DocLineNo, $sufType.''.$mainKey, $firstVal); 
						//echo "<pre>";print_r($this->tempArr); 
					}		
				}										
			}

			$insidertransaction = $this->tempArr;
			$this->tempArr = array();
			//echo "<pre>";print_r($insidertransaction); exit;
			return $insidertransaction;
		}
		catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : insidertransactionData function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}	
	}
	
	public function insiderfnData($input_xml, $fk_id, $xml)
	{
		try
		{
			if(gettype($input_xml) == 'object')
				$input_xml = (array) $input_xml;
				
			$i=0;			
			$farray=array();
			if(!empty($input_xml)){
			foreach($input_xml as $sml)
			{
				//var_dump($xml->footnotes->footnote[0]);
				if(gettype($sml)=='array'){
				foreach($sml as $newsml)
				{					
					foreach($xml->footnotes->footnote[$i]->attributes() as $a=>$b)
					{
						$fn=(array)$b[0];
						if(!empty($fn))
							$farray[]=array('InsiderDocumentID_fk'=>$fk_id,'FootNoteSN'=>$fn[0],'FootNote'=>$newsml);		
					}
					$i++;
				}
				}
				else{
					$fn=(array)$xml->footnotes->footnote[0];
					$fn=$fn['@attributes']['id'];
					$fnname= $xml->footnotes->footnote[0];
					$farray[]=array('InsiderDocumentID_fk'=>$fk_id,'FootNoteSN'=>$fn,'FootNote'=>$fnname);
					
				}
			} 
			}
			return $farray;
		}
		catch(Exception $e)
    	{
			log_message('error', 'Crawler_model : insiderfnData function'.$e->getMessage());
        	throw new Exception('Oops! Something went wrong.');
		}	
	}
	
	public function user_crawel_url($xmlurl,$formsArr,$firmid,$upload_folder){
		$this->upload_folder=$upload_folder;
		$cron_time='12:00';
		$xml = simplexml_load_file($xmlurl);
							
									// Insert into main table and get main fk start									
									$fk_id = $this->insiderdocumentData($xmlurl, $firmid, $xml, $formsArr, $cron_time);
		
		                            if($fk_id)
									{
										// Insert ownership data into owner table
										$this->insiderrepownerData($xml->reportingOwner, $fk_id);
										
										// Insert derivative and non-derivative data into transaction table
										$dervArr = $this->insidertransactionData($xml->derivativeTable, $fk_id, 'derivativeTable_');
										if(count($dervArr)) {
											$this->db->insert_batch('insidertransaction', $dervArr);
										}										
										$nondervArr = $this->insidertransactionData($xml->nonDerivativeTable, $fk_id, 'nonDerivativeTable_');
										if(count($nondervArr)) {
											$this->db->insert_batch('insidertransaction', $nondervArr);
										}	
										
										// Insert footnotes data into footnotes table										
										$fnotes=$this->insiderfnData($xml->footnotes, $fk_id, $xml);
										if(count($fnotes)) {
											$this->db->insert_batch('insiderfn', $fnotes);
										}
									$staus=array('curl_status'=>1);
										$this->db->where('InsiderDocumentID',$fk_id);
										$this->db->update('insiderdocument',$staus);
									}
							return $fk_id;	
		
		
	}
	
}

?>
