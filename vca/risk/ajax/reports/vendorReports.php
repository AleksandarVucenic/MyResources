<?php

include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");

// Initialize
//$employeeData = array();

// GET EMPLOYEE
$sql = "SELECT * FROM tdbContract WHERE siteID = " . $_SESSION['siteID'];
$res = mysql_query($sql);

$debug = array();

$minLikelihood = 0;
$maxLikelihood = 0;

$vendorType = array('vendor' => "vendor");

foreach($vendorType as $vendorTypeIndex => $vendorTypeVal){
    $i = 0;
    while ($dataVendorDB = mysql_fetch_array($res)) {
        $sqlMig = " SELECT r.* FROM `tdbRiskMigrationData` as r 
                    WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
                    WHERE m.riskMigExternalID = " . $dataVendorDB['contractID'] . " AND riskMigType = 4) AND riskMigType = 4";


        $resMig = mysql_query($sqlMig);
        

        $debug[$i] = mysql_num_rows($resMig);
		
		
        if (mysql_num_rows($resMig) > 0) {
            
            $rowMig = mysql_fetch_array($resMig);
            // SET Type ================================================================================================
            $setVendorType = 'vendor';
            $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $vendorType[$setVendorType] = $color;
            

            // Initialize and set Params ===============================================================================
            $fromDate = $rowMig['riskMigLikeFrom'];
            $toDate   = $rowMig['riskMigLikeTo']; // Used for to get Min & Max:  Year and Days
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
                if ($rangeLikeMax > 0) {
                    $maxLikelihood = $maxLikelihood + 1;
                }
            }
            // =========================================================================================================
            $key = $rangLikelihoodDays . '_' . $rowMig['riskMigValue'];
            
            $vendorData[$setVendorType][$key]['likelihoodRange'] = $rangLikelihoodDays;
            $vendorData[$setVendorType][$key]['riskMigValue']    = $rowMig['riskMigValue'];
            
            $vendorData[$setVendorType][$key]['showData'][$i]['Contract_Name']  = $dataVendorDB['contractName'];
            
            $vendorData[$setVendorType][$key]['riskData']['Risk_Value']        = $rowMig['riskMigValue'] . ' %';
            
            $vendorData[$setVendorType][$key]['riskData']['Risk_Probability_Range'] = $roundYear . $roundDay;
            $vendorData[$setVendorType][$key]['riskData']['Expect_From'] = date('d/m/Y', $fromDate);
            $vendorData[$setVendorType][$key]['riskData']['Expect_To']   = date('d/m/Y', $toDate);
            
            

            $i++;
            // ===========================================================================================================
        }
    }
}
// Modifie and Coustomize Array Data =================================================================================
// Add On Foront Zero to line start form zero
foreach($vendorData as $vendorTypeKey => $vendorTypeVal){
    array_unshift($vendorData[$vendorTypeKey], array('riskMigValue' => 0, 'likelihoodRange' => 0));
}
  
// Sort Array By Likelihood Range
foreach ($vendorData as $vendorTypeKey => $vendorTypeVal){
    foreach ($vendorTypeVal as $index => $value) {
        $sortArray[] = $value['likelihoodRange'];
        $i++;
    }
    array_multisort($sortArray, SORT_ASC, $vendorData[$vendorTypeKey]);
}




$dataRiskType = getRiskType(2);
$dataLikelihoodMinMax = getRiskLikelihoodMinMax();

$dataLikelihoodMinMax['min'];
$dataLikelihoodMinMax['max'];

if ($dataLikelihoodMinMax['max'] > $maxLikelihood) {
    $maxLikelihood = $dataLikelihoodMinMax['max'];
}


$data = array(
    'dataGraph'       => $vendorData,
    'dataNormalRatio' => $dataRiskType['riskTypeNormalRatio'],
    'likelihoodMin'   => $minLikelihood,
    'likelihoodMax'   => $maxLikelihood,
    'dataType'        => $vendorType,
    'dataMainType'    => "Contract",
    'debug'           => $sqlMig
);


echo json_encode($data);

?>