<?php
    function get_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    curl_close($ch);
    return $result;
    }
	$mainurl="https://www.sec.gov/Archives/edgar/data/1800";
    $returned_content = get_data($mainurl);
    $first_step = explode( '<table summary="Directory Listing for $full_dir">' , $returned_content);
	//var_dump($first_step[1]);
	//exit;
    $second_step = explode('</table>', $first_step[1]);
	
    $third_step = explode('<tr>', $second_step[0]);
	//echo "<pre>";
	$i=0;
    foreach ($third_step as $key=>$element) {
		$i++;
		if($i==20)
			break;
		//var_dump($element);
		//exit;
    $child_first = explode( '</a>', $element );
	//var_dump($child_first);
	//echo "<pre>";
	if(isset($child_first[1])){
	$content = preg_replace("/<img[^>]+\>/i", "",  $child_first[0]);
	//strip_tags($content)."--".$child_first[1];
	
	$trgeturl= $mainurl."/".strip_tags($content);
	$data=file_get_contents($mainurl."/".strip_tags($content));
	
	 $pagelevel = explode( '<table summary="Directory Listing for $full_dir">' , $data);
	
	$pagelevl_step2 = explode('</table>', $pagelevel[1]);
	
$pagethird_step = explode('<tr>', $pagelevl_step2[0]);

 foreach ($pagethird_step as $key1=>$element1) {
	
	 $child_first2 = explode( '</a>', $element1 );
	
	if(isset($child_first2[1])){
	$content1 = preg_replace("/<img[^>]+\>/i", "",  $child_first2[0]);
$filename=strip_tags($content1);

if(strtolower(substr($filename, strrpos($filename, '.') + 1)) == 'xml' )
{
	echo $xmlurl= $trgeturl."/".$filename;
	
	// if (file_exists($xmlurl)) {
		//		 echo "insode";
    $xml = simplexml_load_file($xmlurl);
	echo "<pre>";
	//var_dump($xml);
	echo $xml->schemaVersion;
	echo $xml->documentType;
	echo $xml->periodOfReport;
	echo $xml->notSubjectToSection16;
	foreach($xml->issuer as $issuer){
		echo $issuer->issuerCik;
		echo $issuer->issuerName;
		echo $issuer->issuerTradingSymbol;
		
	}
	foreach($xml->reportingOwner as $reportingOwner){
		echo $reportingOwner->reportingOwnerId->rptOwnerCik;
		echo $reportingOwner->reportingOwnerId->rptOwnerName;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerStreet1;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerStreet2;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerCity;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerState;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerZipCode;
		echo $reportingOwner->reportingOwnerAddress->rptOwnerStateDescription;
		echo $reportingOwner->reportingOwnerRelationship->isDirector;
		echo $reportingOwner->reportingOwnerRelationship->isOfficer;
		echo $reportingOwner->reportingOwnerRelationship->isTenPercentOwner;
		echo $reportingOwner->reportingOwnerRelationship->isOther;
		echo $reportingOwner->reportingOwnerRelationship->officerTitle;
		echo $reportingOwner->reportingOwnerRelationship->otherText;
		
		
		
	}
	foreach($xml->nonDerivativeTable as $nonDerivativeTable )
	
	var_dump($reportingOwner->nonDerivativeTable->securityTitle);
	echo $reportingOwner->nonDerivativeTable->transactionDate;
	echo $reportingOwner->nonDerivativeTable->transactionCoding;
	echo $reportingOwner->nonDerivativeTable->transactionAmounts;
	echo $reportingOwner->nonDerivativeTable->postTransactionAmounts;
		
	
	
	 //}
	 exit;
	 echo "--------------";
}
 }
	//echo "<pre>";

 }
	}
	
	}
?>