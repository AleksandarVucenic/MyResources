<?php

include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");
//$sql = "SELECT * FROM tdbAssetsDeviceTable WHERE siteID = ". $_SESSION['siteID'];
$sql = "SELECT a.*,b.nodeID, b.systemType  FROM `tdbAssetsGeneral` a INNER JOIN `tdbAssetsDeviceTable` b ON a.nodeID = b.nodeID WHERE b.siteID = " . $_SESSION['siteID'];

//$res = mysql_query($sql);
$assetTypeRes = mysql_query($sql);
$dataAssets = array();


//echo mysql_num_rows($res);
$minLikelihood = 0;
$maxLikelihood = 0;
$assetTypes = array();
$allAssetTypes = array();



// Get ASSET Data Types
/*while($getAssetTypesDB = mysql_fetch_array($res)) {
    $allAssetTypes = $getAssetTypeDB['systemType']; 
}*/
while ($getAssetTypesDB = mysql_fetch_array($assetTypeRes)) {
    
    $getAssetType = $getAssetTypesDB['systemType'];
        
    if($getAssetType == null) { $getAssetType = "other"; }

    if(!array_key_exists($getAssetType,$allAssetTypes)){
        $allAssetTypes[$getAssetType] = $getAssetType;
    }
    
}


foreach ($allAssetTypes as $assetTypeIndex => $assetTypeValue){
	$i = 0;
	
	$sql = "SELECT a.*,b.nodeID, b.systemType  FROM `tdbAssetsGeneral` a INNER JOIN `tdbAssetsDeviceTable` b ON a.nodeID = b.nodeID WHERE b.systemType='".$assetTypeIndex."' AND b.siteID = " . $_SESSION['siteID'];
	
	$res = mysql_query($sql);
	
	while ($dataAssetDB = mysql_fetch_array($res)) {
	    
	    //echo $dataAssetDB['nodeID']. " | " ;
	    $sqlMig = " SELECT r.* FROM `tdbRiskMigrationData` as r 
	                WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
	                WHERE m.riskMigExternalID = " . $dataAssetDB['nodeID'] . ") AND riskMigType = 1";
	
	    $res1 = mysql_query($sqlMig);
	    
	    $assetType = $dataAssetDB['systemType'];
	        
	        /*if($assetType == null) { $assetType = "other"; }
	        
	        if(!array_key_exists($assetType,$assetTypes)){
	            $assetTypes[$assetType] = $assetType;
	            $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	            //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
	            $dataTypes[$assetType]['color'] = $color;
	    
	        }*/
	    
	    
	    // START GETTING DATA
	    if(mysql_num_rows($res1) > 0) {
	        
			$row1 = mysql_fetch_array($res1);
			// SET Type ================================================================================================
	        $assetType = $dataAssetDB['systemType'];
	        $assetType = str_replace(" ", '-', $assetType);
	        if($assetType == null) { $assetType = "other"; }
	        
	        if(!array_key_exists($assetType,$assetTypes)){
	            $assetTypes[$assetType] = $assetType;
	            $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	            //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
	            $assetTypes[$assetType] = $color;
	    
	        }
	        
			
			// Initialize and set Params ===============================================================================
			$fromDate = $row1['riskMigLikeFrom']; 
	        $toDate   = $row1['riskMigLikeTo'];
			$rangLikelihoodDays = ($toDate - $fromDate) / 60 / 60 / 24;
			
			$roundYear = round($rangLikelihoodDays / 365);
	        $roundDay = round($rangLikelihoodDays % 365);
			
			
			// ========================================================================================================
	        // CHECK YEARS
	        if ($roundYear != 0) {
	
	            if ($roundYear == 1) { 
	                $roundYear = $roundYear . " year ";
	            } else {
	                $roundYear = $roundYear . " years ";
	            }
	        } else {
	            $roundYear = "";
	        }
	
	        // CHECK DAYS
	        if ($roundDay != 0) {
	
	            if ($roundDay == 1) {
	                $roundDay = $roundDay . " day ";
	            } else {
	                $roundDay = $roundDay . " days ";
	            }
	        } else {
	            $roundDay = "";
	        }
	
	        if ($maxLikelihood < round($rangLikelihoodDays / 365)) {
	            $maxLikelihood = round($rangLikelihoodDays / 365);
	            $rangeLikeMax = ($rangLikelihoodDays % 365);
	            if($rangeLikeMax > 0){
	                $maxLikelihood = $maxLikelihood + 1;
	            }
	        }
			
			
			
			// ========================================================================================================
			
			//$i = $rangLikelihoodDays . '_' . $row1['riskMigValue'];
			
	        $dataAsset[$assetType][$i]['fullNodNameFull'] = $dataAssetDB['FullNodename'] . '-' . $i;
	        //$dataAsset[$i]['importID']                  = $dataAssetDB['importID'];
	        $dataAsset[$assetType][$i]['nodeID']          = $dataAssetDB['nodeID'];
	        $dataAsset[$assetType][$i]['serialNumber'] = $dataAssetDB['SerialNumber'];
	
	        
	        $dataAsset[$assetType][$i]['riskMigValue']    = $row1['riskMigValue'];
	        $dataAsset[$assetType][$i]['riskMigComment']  = $row1['riskMigComment'];
	        
	        $dataAsset[$assetType][$i]['riskMigFromDate'] = date('d/m/Y', $fromDate);
	        $dataAsset[$assetType][$i]['riskMigToDate']   = date('d/m/Y', $toDate);
	        $dataAsset[$assetType][$i]['systemType']      = $dataAssetDB['systemType'];
	
	        $dataAsset[$assetType][$i]['rangLikelihoodDays'] = $roundYear . $roundDay;
	
	
	
	        $dataAsset[$assetType][$i]['likelihoodRange'] = $rangLikelihoodDays;
	
	        $dataAsset[$assetType][$i]['fullNodName']     = ""; //substr($dataAssetDB['FullNodename'], 0,5).'...';
	
	        if ($dataAssetDB['FullNodename'] == "") {
	            $dataAsset[$assetType][$i]['fullNodNameFull'] = "--";
	            $dataAsset[$assetType][$i]['fullNodName'] = "--";
	        }
			
			
			//dataAsset[$assetType][$i][$roundYear . $roundDay.'_'. $row1['riskMigValue']][$g][''];
			
	
	        $i++;
			// ========================================================================================================
			
	    }
	}
}

// ADD ZERO ON START
foreach($dataAsset as $assetTypeKey => $assetTypeVal){
    array_unshift($dataAsset[$assetTypeKey], array('riskMigValue' => 0, 'likelihoodRange' => 0));
}

// SORT ARRAY
/*foreach ($dataAsset as $assetTypeKey => $assetTypeVal){
    $sortArray = array();
    foreach ($assetTypeVal as  $index => $value)
    {
       $sortArray[] = $value['likelihoodRange'];
       $i++;
    }
    //array_multisort($sortArray, SORT_ASC, $dataAsset[$assetTypeKey]);
}*/

// Functions


function getRiskLikelihoodMinMax() {
    $sql = "SELECT min(riskLikelihoodFromTime) as min, max(riskLikelihoodToTime) as max FROM `tdbRiskLikelihood`";
    $res = mysql_query($sql);
    $dataLikelihood = mysql_fetch_array($res);
    return $dataLikelihood;
}

$dataRiskType = getRiskType(1);
/*$dataLikelihoodMinMax = getRiskLikelihoodMinMax();

$dataLikelihoodMinMax['min'];
$dataLikelihoodMinMax['max'];*/

if ($dataLikelihoodMinMax['max'] > $maxLikelihood) {
    $maxLikelihood = $dataLikelihoodMinMax['max'];
}


$data = array(
    'dataGraph'       => $dataAsset,
    'dataNormalRatio' => $dataRiskType['riskTypeNormalRatio'],
    'likelihoodMin'   => $minLikelihood,
    'likelihoodMax'   => $maxLikelihood,
    'dataType'        => $assetTypes,
    'dataMainType'    => "Assets",
    'debug'           => $dataAsset
);

echo json_encode($data);

?>
