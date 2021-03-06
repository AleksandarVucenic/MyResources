<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");

$siteID = $_SESSION['siteID'];
//$debug = array();

$minLikelihood = 0;
$maxLikelihood = 0;

$employeeType = array('stakeholders' => "stakeholders");
$debug = getAllStakeholdersBySite($siteID);
$employeeDataRows = getAllStakeholdersBySite($siteID);
foreach($employeeType as $employeeTypeIndex => $emploeyeeTypeVal){
    $i = 0;
    foreach($employeeDataRows as $employeeID => $employeeValue) {
        
		
		
        
            
           
            // SET Type ================================================================================================
            $setEmployeeType = 'stakeholders';
            $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $employeeType[$setEmployeeType] = $color;
            

            // Initialize and set Params ===============================================================================
            $fromDate = $employeeValue['likeFrom'];
            $toDate   = $employeeValue['likeTo']; // Used for to get Min & Max:  Year and Days
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
            $key = $rangLikelihoodDays . '_' . $employeeValue['maxRisk'];
            
            $employeeData[$setEmployeeType][$key]['likelihoodRange'] = $rangLikelihoodDays;
            $employeeData[$setEmployeeType][$key]['riskMigValue']    = $employeeValue['maxRisk'];
            
            //$employeeData[$setEmployeeType][$key]['showData'][$i]['employeeID']        = $employeeValue['maxRisk'];
            $employeeData[$setEmployeeType][$key]['showData'][$i]['Name']  = $employeeValue['name'];
            
            $employeeData[$setEmployeeType][$key]['riskData']['Risk_Value']        = $employeeValue['maxRisk'] . ' %';
            //$employeeData[$setEmployeeType][$key]['riskData']['riskMigComment']    = $rowMig['riskMigComment'];
            
            $employeeData[$setEmployeeType][$key]['riskData']['Risk_Probability_Range'] = $roundYear . $roundDay;
            $employeeData[$setEmployeeType][$key]['riskData']['Expect_From'] = date('d/m/Y', $fromDate);
            $employeeData[$setEmployeeType][$key]['riskData']['Expect_To']   = date('d/m/Y', $toDate);
            
            

            $i++;
            // ===========================================================================================================
        
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
    'dataMainType'    => "Stakeholders",
    'debug'           => $employeeData
);


echo json_encode($data);

?>