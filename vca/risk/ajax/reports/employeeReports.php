<?php

include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");

// Initialize
//$employeeData = array();

// GET EMPLOYEE
$sql = "SELECT * FROM tdbTMPEmployee WHERE siteID = " . $_SESSION['siteID'];
$res = mysql_query($sql);

$debug = array();

$minLikelihood = 0;
$maxLikelihood = 0;

$employeeType = array('employee' => "employee");

foreach($employeeType as $employeeTypeIndex => $emploeyeeTypeVal){
    $i = 0;
    while ($dataEmployeeDB = mysql_fetch_array($res)) {
        $sqlMig = " SELECT r.* FROM `tdbRiskMigrationData` as r 
                    WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
                    WHERE m.riskMigExternalID = " . $dataEmployeeDB['employeeID'] . " AND riskMigType = 2) AND riskMigType = 2";


        $resMig = mysql_query($sqlMig);
        

        $debug[$i] = mysql_num_rows($resMig);
		
		
        if (mysql_num_rows($resMig) > 0) {
            
            $rowMig = mysql_fetch_array($resMig);
            // SET Type ================================================================================================
            $setEmployeeType = 'employee';
            $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $employeeType[$setEmployeeType] = $color;
            

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
            
            $employeeData[$setEmployeeType][$key]['likelihoodRange'] = $rangLikelihoodDays;
            $employeeData[$setEmployeeType][$key]['riskMigValue']    = $rowMig['riskMigValue'];
            
            //$employeeData[$setEmployeeType][$key]['showData'][$i]['employeeID']        = $dataEmployeeDB['employeeID'];
            $employeeData[$setEmployeeType][$key]['showData'][$i]['Employee_Name']  = $dataEmployeeDB['employeeFullName'];
            
            $employeeData[$setEmployeeType][$key]['riskData']['Risk_Value']        = $rowMig['riskMigValue'] . ' %';
            //$employeeData[$setEmployeeType][$key]['riskData']['riskMigComment']    = $rowMig['riskMigComment'];
            
            $employeeData[$setEmployeeType][$key]['riskData']['Risk_Probability_Range'] = $roundYear . $roundDay;
            $employeeData[$setEmployeeType][$key]['riskData']['Expect_From'] = date('d/m/Y', $fromDate);
            $employeeData[$setEmployeeType][$key]['riskData']['Expect_To']   = date('d/m/Y', $toDate);
            
            

            $i++;
            // ===========================================================================================================
        }
    }
}
// Modifie and Coustomize Array Data =================================================================================
// Add On Foront Zero to line start form zero
foreach($employeeData as $employeeTypeKey => $employeeTypeVal){
    array_unshift($employeeData[$employeeTypeKey], array('riskMigValue' => 0, 'likelihoodRange' => 0));
}
    
// Sort Array By Likelihood Range
foreach ($employeeData as $employeeTypeKey => $employeeTypeVal){
    foreach ($employeeTypeVal as $index => $value) {
        $sortArray[] = $value['likelihoodRange'];
        $i++;
    }
    array_multisort($sortArray, SORT_ASC, $employeeData[$employeeTypeKey]);
}




$dataRiskType = getRiskType(2);
$dataLikelihoodMinMax = getRiskLikelihoodMinMax();

$dataLikelihoodMinMax['min'];
$dataLikelihoodMinMax['max'];

if ($dataLikelihoodMinMax['max'] > $maxLikelihood) {
    $maxLikelihood = $dataLikelihoodMinMax['max'];
}


$data = array(
    'dataGraph'       => $employeeData,
    'dataNormalRatio' => $dataRiskType['riskTypeNormalRatio'],
    'likelihoodMin'   => $minLikelihood,
    'likelihoodMax'   => $maxLikelihood,
    'dataType'        => $employeeType,
    'dataMainType'    => "Employee",
    'debug'           => $dataRiskType['riskTypeNormalRatio']
);


echo json_encode($data);

?>