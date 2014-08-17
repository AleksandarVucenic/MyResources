<?php

// Include required field
include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");

// Initialization Data
$siteID = $_SESSION['siteID'];
$siteName = displaySiteName($siteID);
$getData  = countRiskAutoBySite($siteID);
$siteDataGraph = array();
$siteItemsTypes = array();
$i = 0;
foreach ($getData['data'] as $index => $value ) {
    
    
    $rand  = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
    //$color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    $siteItemsTypes[$value['dataType']] = $color;
    
    $siteDataGraph[$value['dataType']][$index]['Data_Type'] = $value['dataType'];
    $siteDataGraph[$value['dataType']][$index]['Max_Risk'] = $value['maxRisk'];
    
    $siteDataGraph[$value['dataType']][$index]['showData'][$i]['Data_Type'] = $value['dataType'];
    
    $siteDataGraph[$value['dataType']][$index]['risk']['Max_Risk'] = $value['maxRisk'] . ' %';
    $siteDataGraph[$value['dataType']][$index]['risk']['Expected_From'] = date("d/m/Y", $value['minLike']);
    $siteDataGraph[$value['dataType']][$index]['risk']['Expected_To']   = date("d/m/Y", $value['maxLike']);
    
    
    $i++;
}



$datasToShow = array(
    'dataGraph'  => $siteDataGraph,
    'graphType'  => 'barchart',
    'dataType'   => $siteItemsTypes,
    'debug' => $debug
    
);

echo json_encode($datasToShow);
