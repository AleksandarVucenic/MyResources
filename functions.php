<?phpa

function getRiskType($id) {
    $sql = "SELECT * FROM `tdbRiskItemTypes` WHERE riskItemTypeID = $id LIMIT 0,1";
    $res = mysql_query($sql);
    return mysql_fetch_array($res);
}


function getRiskLikelihoodMinMax() {
    $sql = "SELECT min(riskLikelihoodFromTime) as min, max(riskLikelihoodToTime) as max FROM `tdbRiskLikelihood`";
    $res = mysql_query($sql);
    $dataLikelihood = mysql_fetch_array($res);
    return $dataLikelihood;
}


// RISK SECTOR ================================================================================================================================================================
                
function getRiskData($itemID = null,$typeID = null, $siteID = null) {
    $sql = " SELECT r.* FROM `tdbRiskMigrationData` as r 
		     WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = $itemID AND m.riskMigType = $typeID) AND  r.riskMigType = $typeID AND riskMigSiteID = $siteID
	";           
    $res = mysql_query($sql);
    $data = null;
    
    if(mysql_num_rows($res) > 0){
    
        while($row = mysql_fetch_array($res)){ 
            $data = $row;
        } 
        
    }else{ 
        $data['riskMigValue'] = 0;
        
    }
    
    
    
    return $data;
    
}

function getRiskTypeData($typeID) {
	$sql = "SELECT * FROM tdbRiskItemTypes WHERE riskItemTypeID = '$typeID'";
	$res = mysql_query($sql);
	
	$typeData = array();
	
	while($row = mysql_fetch_array($res)) {
			
		$typeData['riskItemTypeID']      = $row['riskItemTypeID'];
		$typeData['riskTypeName']        = $row['riskTypeName']; 
		$typeData['riskTypeCoef']        = $row['riskTypeCoef'];
		$typeData['riskTypeNormalRatio'] = $row['riskTypeNormalRatio']; 

	}	
	
	return $typeData;
}

function getAllRiskTypes(){
    $sql = "SELECT * FROM tdbRiskItemTypes";
    $res = mysql_query($sql);
    $typeData = array();
    $i = 1;
    
    while($row = mysql_fetch_array($res)){
        
        $typeData[$i]['riskItemTypeID']      = $row['riskItemTypeID'];
        $typeData[$i]['riskTypeName']        = $row['riskTypeName']; 
        $typeData[$i]['riskTypeCoef']        = $row['riskTypeCoef'];
        $typeData[$i]['riskTypeNormalRatio'] = $row['riskTypeNormalRatio']; 
        
        $i++;
    }
    
    return $typeData;
}

function countRiskAutoBySitea($siteID) {
    
    $riskTypes = getAllRiskTypes();
    $riskTypesData = array();
    
    //var_dump($riskTypes);
    $totalMax = 0;
    $coef = 0;
    //$riskLikeFrom = null;
    $riskLikeTo   = null;
    
    $minRiskLike = array();
    $maxRiskLike = array();
    
    foreach ($riskTypes as $key => $value) {
        
        $sql = "SELECT r.*, max(r.riskMigValue) as maxRisk, min(riskMigLikeFrom) as minLike, max(riskMigLikeTo) as maxLike 
                FROM `tdbRiskMigrationData` as r  
                WHERE r.riskMigSiteID = '$siteID' AND r.riskMigType = '".$value['riskItemTypeID']."' 
                AND r.createdDate = ( 
                        SELECT max(createdDate) FROM `tdbRiskMigrationData` AS m 
                        WHERE r.riskMigExternalID = m.riskMigExternalID AND m.riskMigType = '".$value['riskItemTypeID']."' AND m.riskMigSiteID = '$siteID'
                            )
                GROUP BY riskMigType";
        
        $res = mysql_query($sql);
        
        $riskCoef = $value['riskTypeCoef'];
                
        // Get data from mig table
        
        //$riskTypeData['data'][$value['riskItemTypeID']]['riskTypeCoef'] = $value['riskTypeCoef'];
        
        $riskTypeData['dataType'][$value['riskItemTypeID']] = $value ;
        
        //['riskTypeName']
        
        while( $row = mysql_fetch_array($res) ){
            /*if( $key  == 3 ){  //////////////////////////////////////////////////////////////////////////////////////////////
                $dataStakeholder = getStakeholderDataBySite($siteID);
                $row['maxRisk'] = $dataStakeholder[$siteID]['data']['maxRisk'];
                $row['minLike'] = $dataStakeholder[$siteID]['data']['likeFrom'];
                $row['maxLike'] = $dataStakeholder[$siteID]['data']['maxLike'];
                $row['riskMigType'] = 3;
            } //////////////////////////////////////////////////////////////////////////////////////////////////////
			 * */
            $riskTypeData['data'][$value['riskItemTypeID']]['maxRisk']      = $row['maxRisk'];
            $riskTypeData['data'][$value['riskItemTypeID']]['riskMigType']  = $row['riskMigType'];
            $riskTypeData['data'][$value['riskItemTypeID']]['minLike']      = $row['minLike'];
            $riskTypeData['data'][$value['riskItemTypeID']]['maxLike']      = $row['maxLike'];
            
            $riskTypeData['data'][$value['riskItemTypeID']]['dataType']     = $value['riskTypeName'];
            
            $minRiskLike[$key] = $row['minLike'];
            $maxRiskLike[$key] = $row['maxLike'];
            
            $coef += ($row['maxRisk'] * $riskCoef);
            $totalMax += $row['maxRisk']; 
            
        }

        
    
    
    
    }
    
    $minValue = null;
    $maxValue = null;
    
    /*foreach ($riskTypeData['data'] as $key => $value) {
        $minValue = $value['minLike'];
        if($value['minLike'] < $minValue){
            $minValue = $value['minLike'];
        }
        
        if($value['maxLike'] > $maxValue AND $value['maxLike'] != null) {
            $maxValue = $value['maxLike'];
        }
        
    }*/
    
    /*$percent = 0;
    $coefVaue = 0;
    foreach ($riskTypeData['data'] as $key => $value) {
        if($value['maxRisk'] != null){
        $riskTypeData['risk'][$key]['maxRisk'] = $value['maxRisk'];
        $riskTypeData['risk'][$key]['percent'] = ($value['maxRisk'] / $totalMax)*100;
        $riskTypeData['risk'][$key]['coef']    = (($value['maxRisk'] / $totalMax) * $value['riskTypeCoef'])*100;
        }
    }*/
    
    if($coef == null) { $coef = 0; }
    if($totalMax == null) { $totalMax = 0; }
    
    
    $riskTypeData['risk']['coef'] = $coef;
    $riskTypeData['risk']['total'] = $totalMax; 
    $riskTypeData['risk']['minLike'] = min($minRiskLike);
    $riskTypeData['risk']['maxLike'] = max($maxRiskLike);
    $riskTypeData['riskTypes'] = $riskTypes;
    
    return  $riskTypeData;

}

function getRiskClassificationValue($riskValue) {
    
    if($riskValue == null) { $riskValue =0; }
    
    $sql = "SELECT r . * , min( v.riskValue ) AS maxRisk, max( m.riskValue ) AS minRisk
                            FROM tdbRiskClassification AS r
                            LEFT JOIN tdbRiskClassification AS v ON r.riskValue < v.riskValue
                            LEFT JOIN tdbRiskClassification AS m ON r.riskValue >= m.riskValue
                            GROUP BY r.riskID";

    $res = mysql_query($sql);

    $classData = array();
    $i = 0;
    while($row = mysql_fetch_array($res)) {
        $minValue = $row['minRisk'];
        $maxValue = $row['maxRisk'];

        if($maxValue == NULL) { $maxValue = 100; }

        if($minValue != 0){ $minValue = $minValue + 1; }

        if(($minValue <= $riskValue) AND ($maxValue >= $riskValue)){
            $classData[$i]['riskID']                   = $row['riskID'];
            $classData[$i]['riskComment']              = $row['riskComment']; 
            $classData[$i]['riskLevel']                = $row['riskLevel'];
            $classData[$i]['riskCost']                 = $row['riskCost']; 
            $classData[$i]['riskValue']                = $row['riskValue'];
            $classData[$i]['riskClassificationColor']  = $row['riskClassificationColor'];
            $classData[$i]['riskCurrency']             = $row['riskCurrency'];
            $classData[$i]['minRisk']                  = $row['minRisk'];
            $classData[$i]['maxRisk']                  = $row['maxRisk'];

            $i++;
        }

    }	 

    return $classData;
}

function addNewMigRisk($externalID, $typeID, $data, $siteID) {
    
    if($data['migrationValue'] != 0 AND $data['migrationValue'] != ""){
        if($data['migrationLikelihoodFrom'] != ""){ $data['migrationLikelihoodFrom']   = strtotime(str_replace('/', '-', $data['migrationLikelihoodFrom'])); }
        if($data['migrationLikelihoodTo'] != "")  { $data['migrationLikelihoodTo'] = strtotime(str_replace('/', '-', $data['migrationLikelihoodTo'])); }
        
        $data = "
                `riskMigValue` = '".$data['migrationValue']."',
                `riskMigComment` = '".$data['migrationComment']."',
                `riskMigLikeFrom` = '".$data['migrationLikelihoodFrom']."',
                `riskMigLikeTo` = '".$data['migrationLikelihoodTo']."',
                `createdBy` = '".$GLOBALS['userID']."',
                `createdDate` = '".$GLOBALS['lastUpdate']."',
                `riskMigExternalID` = '$externalID',
                `riskMigType` = '$typeID',
                `riskMigSiteID` = '$siteID'
        ";

        
        $sql = "INSERT INTO tdbRiskMigrationData SET $data ";

        $res = mysql_query($sql);

    }
    //var_dump($data);
}

function deleteMigRisk($externalID = null, $typeID = null,  $siteID = null)
{
    $siteWhere = null;
    $typeWhere = null;
    $itemWhere = null;
    $whereQuery = null;
    
    
    if($siteID     != null) { $siteWhere =  " AND riskMigSiteID = $siteID "; }
    if($typeID     != null) { $typeWhere = " AND riskMigType = $typeID "; }
    if($externalID != null) { $itemWhere = " AND riskMigExternalID = $externalID "; }
    
    $whereQuery = $itemWhere.$typeWhere.$siteWhere;
    $whereQuery = trim($whereQuery);
    $whereQuery = preg_replace('/^AND/', '', $whereQuery);
    
    $sql = "DELETE FROM tdbRiskMigrationData WHERE $whereQuery";
    $res = mysql_query($sql);
}

function showAutoriskTableInfo ($types, $data) {
    
    $autoInfoData = array();
    
    //FOR TABLE INFO
    foreach ($types as $index => $value ) {
        
        
        
        if(array_key_exists($value['riskItemTypeID'], $data)) {

            $autoInfoData[$value['riskItemTypeID']]['riskTypeCoef'] = $value['riskTypeCoef'];
            $autoInfoData[$value['riskItemTypeID']]['riskTypeID']   = $value['riskItemTypeID']; 
            $autoInfoData[$value['riskItemTypeID']]['riskTypeName'] = $value['riskTypeName'];
            $autoInfoData[$value['riskItemTypeID']]['maxRisk']      = $data[$value['riskItemTypeID']]['maxRisk']; 
            $autoInfoData[$value['riskItemTypeID']]['minLike']      = date('d/m/Y', $data[$value['riskItemTypeID']]['minLike']);
            $autoInfoData[$value['riskItemTypeID']]['maxLike']      = date('d/m/Y', $data[$value['riskItemTypeID']]['maxLike']);
        } else {
            //echo $value['riskItemTypeID'];
            $autoInfoData[$value['riskItemTypeID']]['riskTypeCoef'] = $value['riskTypeCoef'];
            $autoInfoData[$value['riskItemTypeID']]['riskTypeID']   = $value['riskItemTypeID'];
            $autoInfoData[$value['riskItemTypeID']]['riskTypeName'] = $value['riskTypeName'];
            $autoInfoData[$value['riskItemTypeID']]['maxRisk']      = 0;
            $autoInfoData[$value['riskItemTypeID']]['minLike']      = "";
            $autoInfoData[$value['riskItemTypeID']]['maxLike']      = "";
        }
        $i++;
    }
    
    return  $autoInfoData;
    
}


function getSiteRisk($siteID){
	$sqlMig = "SELECT s.siteID, s.siteName,r.*, 
                    max(r.riskMigValue) as riskMigValue, r.riskMigComment, min(r.riskMigLikeFrom ) as riskMigLikeFrom, max(r.riskMigLikeTo ) as riskMigLikeTo 
                    FROM `tdbRiskMigrationData` as r 
                    JOIN tdbAssetsGeneral as a ON a.importID=r.riskMigExternalID 
                    JOIN tdbSite as s ON s.siteID=a.siteID
                    WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
                    WHERE m.riskMigExternalID = a.importID ) and s.siteID = ".$siteID;
	$resMig = mysql_query($sqlMig);
    $migRow = mysql_fetch_array($resMig);

    $migrationRisk    = $migRow['riskMigValue'];
    
    return $migrationRisk;
}



function getRiskMigrationDataItem ($itemID, $typeID) {
    
   $sqlData = "SELECT r.* FROM `tdbRiskMigrationData` as r 
                WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
                WHERE m.riskMigExternalID = $itemID AND riskMigType = $typeID) AND r.riskMigExternalID = $itemID AND riskMigType = $typeID";
    
    $result = mysql_query($sqlData);
    $itemData = array();
    $itemDataDB = mysql_fetch_array($result);
    
    /*
    $itemData['migrationValue']          = $itemDataDB['riskMigValue'];
    $itemData['migrationLikelihoodFrom'] = $itemDataDB['riskMigLikeFrom'];
    $itemData['migrationLikelihoodTo']   = $itemDataDB['riskMigLikeTo'];
    $itemData['riskMigExternalID']       = $itemDataDB['riskMigExternalID'];
    $itemData['riskMigType']             = $itemDataDB['riskMigType'];
    $itemData['riskMigSiteID']           = $itemDataDB['riskMigSiteID'];
    */
    return $itemDataDB;
    
}

/* *
 * ========================================================================
 * - getStakeHolderConnections($employeeID) 
 * ========================================================================
 * Description:
 * ------------------------------------------------------------------------
 * Get connections for employee 
 * ========================================================================
 * @var "$employeeID" (int) - Employee ID from table tdbTMPEmployee 
 * ========================================================================
 * */
function getStakeHoldersConnections($employeeID) {
    
    $siteIDConnection = array();
    $sqlCon = "SELECT * FROM tdbEmployeeConnection WHERE connectionType='DutyBySite' AND employeeID = '$employeeID' ";
    $resultCon = mysql_query($sqlCon);
    $i = 0;
    
    while($dataDB = mysql_fetch_array($resultCon)) {
        $siteIDConnection['data'][$i] = $dataDB['objectID'];
        $siteIDConnection['ids'][$i] = $dataDB['objectID'];
        $i++;
    }
    
    return $siteIDConnection;
    
} 

function updateMigRiskSite($itemID, $typeID, $siteID) {
    $sql = "UPDATE tdbRiskMigratonData SET riskMigSiteID = '$siteID' WHERE riskMigExternalID = '$siteID'";
    $res = mysql_query($sql);
}



function getRiskFromItem($itemID, $typeID, $siteID) {
    $dataItem = array();
    $sql = "SELECT * FROM tdbRiskMigrationData r
            WHERE r.createdDate = ( 
                SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = '".$itemID."' AND m.riskMigType = '".$typeID."' AND m.riskMigSiteID = '".$siteID."'
            )
            ";
    $res = mysql_query($sql);
    
    $dataDB = mysql_fetch_array($res);
    
    $dataItem['itemID']         = $dataDB['riskMigExternalID'];
    $dataItem['maxRisk']        = $dataDB['riskMigValue'];
    $dataItem['siteID']         = $dataDB['riskMigSiteID'];
    $dataItem['likelihoodFrom'] = $dataDB['riskMigLikeFrom'];
    $dataItem['likelihoodTo']   = $dataDB['riskMigLikeTo'];
    
    return $dataItem;
    //var_dump(mysql_num_rows($res));
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getStakeholderConnection($employeeID){
    $siteConnections = array();
    $sqlCon = "SELECT * FROM tdbEmployeeConnection WHERE employeeID = '$employeeID'";
    $resCon = mysql_query($sqlCon);
    $i = 0;
    
    while($dataDB = mysql_fetch_array($resCon)){
        if(!array_key_exists($dataDB['connectionType'], $siteConnections)){ $i=0; }
        $siteConnections[$dataDB['connectionType']][$i]['connectionID'] = $dataDB['connectionID'];
        $siteConnections[$dataDB['connectionType']][$i]['objectID']     = $dataDB['objectID'];
        $siteConnections[$dataDB['connectionType']][$i]['employeeID']   = $dataDB['employeeID'];
        $siteConnections[$dataDB['connectionType']][$i]['description']  = $dataDB['description'];
        $siteConnections[$dataDB['connectionType']][$i]['conType']      = $dataDB['connectionType'];
        $i++;
    }
    //var_dump($siteConnections);
    return $siteConnections;
}

// Get all sites form buseinss unit and calculate each one
function getAllSitesFromBU($businessUnitData,$activePhase) {
    
    $dataSite = array();
    
    if(is_array($businessUnitData)) {
        
        foreach($businessUnitData as $key => $value) {
            
            $maxRiskSite = 0;
            //var_dump($value['objectID']);
            $sql = "SELECT * FROM tdbSite WHERE siteBusinessUnitID = '" . $value['objectID'] . "' AND projectPhaseID = '$activePhase'";
            $res = mysql_query($sql);
            $i = 0;
            
            while($dataDB = mysql_fetch_array($res)) {
                $siteID    = $dataDB['siteID'];
                $businesID = $dataDB['siteBusinessunitID'];
                $dataSite[$siteID]['siteID']         = $dataDB['siteID'];
                $dataSite[$siteID]['businessUnitID'] = $dataDB['siteBusinessunitID'];
                $dataSite[$siteID]['siteName']       = $dataDB['siteName'];
                $dataSite[$siteID]['likeFrom']       = null;
                $dataSite[$siteID]['likeTo']         = null;
                
                // Count Site Risk Value
                if($dataDB['migrationType'] == 2) {
                    $dataRisk = getRiskFromItem($siteID, 100, $siteID);
                    $dataSite[$siteID]['maxRisk']  = $dataRisk['maxRisk']; 
                    // CHECK FOR LAST DATE
                    if ($dataRisk['likelihoodFrom'] == ""){ $dataRisk['likelihoodFrom'] = null; }
                    if ($dataRisk['likelihoodTo'] == ""){ $dataRisk['likelihoodTo'] = null; }
                    
                    if ($dataSite[$siteID]['likeFrom'] == null){
                        $dataSite[$siteID]['likeFrom'] = $dataRisk['likelihoodFrom'];
                    }
                    if($dataSite[$siteID]['likeFrom'] >= $dataRisk['likelihoodFrom']){
                        $dataSite[$siteID]['likeFrom'] = $dataRisk['likelihoodFrom'];
                    }
                    if ($dataSite[$siteID]['likeTo'] <= $dataRisk['likelihoodTo']){
                        $dataSite[$siteID]['likeTo']   = $dataRisk['likelihoodTo'];
                    }
                    //var_dump($dataRisk);
                    //echo "test $siteID <hr/>";
                } else {
                    
                    $dataForCalc = countRiskAutoBySite($siteID);
                    $riskTypes = getAllRiskTypes();
                    
                    $autoInfoData =  showAutoriskTableInfo ($dataForCalc['riskTypes'], $dataForCalc['data']);
                    foreach ($autoInfoData as $index => $value1) {
                        //var_dump($value1); echo " $siteID <hr/>";
                        if($value1['maxRisk'] > 0){
                            if ($value1['minLike'] != "" ){ $value1['minLike'] = strtotime(str_replace('/', '-', $value1['minLike'])); }
                            if ($value1['maxLike'] != ""){ $value1['maxLike'] = strtotime(str_replace('/', '-', $value1['maxLike'])); }
                            
                            if ($value1['riskTypeID'] != 3){
                                $dataSite[$siteID]['maxRisk'] += $value1['maxRisk'] * $value1['riskTypeCoef'];

                                if( $value1['minLike'] != ""){

                                    if($dataSite[$siteID]['likeFrom'] == null){
                                        $dataSite[$siteID]['likeFrom'] = $value1['minLike'];
                                    }

                                    if($dataSite[$siteID]['likeFrom'] > $value1['minLike']){
                                        $dataSite[$siteID]['likeFrom'] = $value1['minLike']; //echo " - $siteID<hr>";
                                    }
                                }

                                if($dataSite[$siteID]['likeTo'] <= $value1['maxLike']){
                                    $dataSite[$siteID]['likeTo'] = $value1['maxLike'];

                                }
                            }
                        }
                    }
                    
                }
                //var_dump($autoInfoData);
                $i++;
            } // End Site While
        }
    }
    return $dataSite;
}

function stakeHolderGetSites($siteData, $activePhase) {
    $dataSite = array();
    foreach ($siteData as $index => $value) {
        $sql = "SELECT * FROM tdbSite WHERE siteID = '" . $value['objectID'] . "' AND projectPhaseID = '$activePhase'";
        $res = mysql_query($sql);
        $i = 0;
        
        while ($dataDB = mysql_fetch_array($res)) {
            
            $siteID    = $dataDB['siteID'];
            $businesID = $dataDB['siteBusinessunitID'];
            
            //if(!array_key_exists($siteID, $dataBU)){
                $dataSite[$siteID]['siteID']           = $dataDB['siteID'];
                $dataSite[$siteID]['siteName'] = $dataDB['siteName'];
                $dataSite[$siteID]['businessUnitID'] = $dataDB['siteBusinessunitID'];


                if($dataDB['migrationType'] == 2) {
                   $dataRisk = getRiskFromItem($siteID, 100, $siteID);
                   $dataSite[$siteID]['maxRisk']  = $dataRisk['maxRisk']; 
                   
                    if ($dataRisk['likelihoodFrom'] == ""){ $dataRisk['likelihoodFrom'] = null; }
                    if ($dataRisk['likelihoodTo'] == ""){ $dataRisk['likelihoodTo'] = null; }
                    
                    if($dataSite[$siteID]['likeFrom'] == null){ $dataSite[$siteID]['likeFrom'] = $dataRisk['likelihoodFrom'];}
                    if($dataSite[$siteID]['likeFrom'] >= $dataRisk['likelihoodForm']){
                        $dataSite[$siteID]['likeFrom'] = $dataRisk['likelihoodFrom'];
                    }
                    if($dataSite[$siteID]['likeTo'] <= $dataRisk['likelihoodTo']){
                        $dataSite[$siteID]['likeTo']   = $dataRisk['likelihoodTo'];
                    }
                } else {
                    $dataForCalc = countRiskAutoBySite($siteID);
                    $riskTypes = getAllRiskTypes();

                    $autoInfoData = showAutoriskTableInfo($dataForCalc['riskTypes'], $dataForCalc['data']);
                    foreach ($autoInfoData as $riskID => $riskValue) {
                        if($riskValue['maxRisk'] > 0){
                            if ($riskValue['minLike'] != ""){ $riskValue['minLike'] = strtotime(str_replace('/', '-', $riskValue['minLike'])); }
                            if ($riskValue['maxLike'] != ""){ $riskValue['maxLike'] = strtotime(str_replace('/', '-', $riskValue['maxLike'])); }

                            if ($riskValue['riskTypeID'] != 3) {
                                $dataSite[$siteID]['maxRisk'] += $riskValue['maxRisk'] * $riskValue['riskTypeCoef'];

                                if($dataSite[$siteID]['likeFrom'] == null){ $dataSite[$siteID]['likeFrom'] = $riskValue['minLike']; }
                                if($dataSite[$siteID]['likeFrom'] >= $riskValue['minLike'] ){ $dataSite[$siteID]['likeFrom'] = $riskValue['minLike']; }

                                if($dataSite[$siteID]['likeTo'] <= $riskValue['maxLike']){
                                    $dataSite[$siteID]['likeTo'] = $riskValue['maxLike'];
                                }

                            }
                        }
                        //
                    }
                    
                    
                }
                $i++;
                
            //}
            
        }
    }
    
    
    return $dataSite;
    
}


/** 
 * GET ASSETS FOR Calculate
 * -----------------------------------------------------------------------
 * DESCRIPTION: 
 * =======================================================================
 * @var (array) $assetData
 * @var (int)   $activePhase
 * =======================================================================
 **/
function stakeHolderGetAssets ($assetsData, $activePhase) {
    $dataAssets = array();
    //var_dump($assetsData);
    if (is_array($assetsData)) {
        $i = 0;
        
        foreach ($assetsData as $index => $value) {
            
            $sql = "
                SELECT * FROM tdbAssetsGeneral a JOIN tdbRiskMigrationData r ON a.nodeID = r.riskMigExternalID AND r.riskMigType = 1 
                WHERE r.createdDate = ( 
                        SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = '".$value['objectID']."' AND m.riskMigType = 1
                    )
                ";
            
            $res = mysql_query($sql);
            
            while ($dataDB = mysql_fetch_array($res)) {
                $siteID = $dataDB['siteID'];
                $nodeID = $dataDB['nodeID'];
                $dataAssets[$siteID][$nodeID]['itemID']   = $nodeID;
                $dataAssets[$siteID][$nodeID]['siteID']   = $siteID;
                $dataAssets[$siteID][$nodeID]['maxRisk']  = $dataDB['riskMigValue'];
                $dataAssets[$siteID][$nodeID]['likeFrom'] = $dataDB['riskMigLikeFrom'];
                $dataAssets[$siteID][$nodeID]['likeTo']   = $dataDB['riskMigLikeTo'];
                
                
            }
        }
    }
    //var_dump($dataAssets);
    return $dataAssets;
}

// Get data form Harvare (all asets)
function stakeholderGetHardvare ($assetsData, $activePhase) {
    $dataAssets = array();
    //var_dump($assetsData);
    if (is_array($assetsData)) {
        foreach ($assetsData as $index => $value) {
            $sql = "SELECT * FROM tdbAssetsDeviceTable ag 
                JOIN tdbAssetType at ON at.assetTypeName = ag.systemType OR at.assetTypeName = ag.systemSubType 
                JOIN tdbRiskMigrationData r ON ag.nodeID = r.riskMigExternalID 
                WHERE at.assetTypeID = '".$value['objectID']."'
                AND r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = r.riskMigExternalID AND m.riskMigType = 1 )
                
                ";
            //$sql = "SELECT * FROM tdbAssetsGeneral WHERE nodeID = '".$value['objectID']."' AND projectPhaseID = '$activePhase'";
            $res = mysql_query($sql);
            
            //echo mysql_error();
            //$num = mysql_num_rows($res);
            while ($dataDB = mysql_fetch_array($res)) {
                $siteID    = $dataDB['siteID'];
                $nodeID    = $dataDB['nodeID'];
                $dataAssets[$siteID][$nodeID]['itemID']        = $dataDB['nodeID'];
                $dataAssets[$siteID][$nodeID]['assetTypeID']   = $dataDB['assetTypeID'];
                $dataAssets[$siteID][$nodeID]['assetTypeName'] = $dataDB['assetTypeName'];
                $dataAssets[$siteID][$nodeID]['maxRisk']       = $dataDB['riskMigValue'];
                $dataAssets[$siteID][$nodeID]['likeFrom']      = $dataDB['riskMigLikeFrom'];
                $dataAssets[$siteID][$nodeID]['likeTo']        = $dataDB['riskMigLikeTo'];
            }
        }
        
    }
    //var_dump($dataAssets);
    return $dataAssets; 
}



function stakeholderGetApplications ($applicationsData, $activePhase) {
    $dataApplications = array();
    //var_dump($applicationsData);
    if (is_array($applicationsData)) {
        foreach ($applicationsData as $index => $value) {
            $sql = "SELECT * FROM tdbAIApplication a 
                JOIN tdbRiskMigrationData r ON a.id = r.riskMigExternalID 
                WHERE 
                r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = '".$value['objectID']."' AND m.riskMigType = 6 )
                ";
            //$sql = "SELECT * FROM tdbAssetsGeneral WHERE nodeID = '".$value['objectID']."' AND projectPhaseID = '$activePhase'";
            $res = mysql_query($sql);
            
            //echo mysql_error();
            //$num = mysql_num_rows($res);
            while ($dataDB = mysql_fetch_array($res)) {
                $siteID    = $dataDB['siteID'];
                $appID     = $dataDB['id'];
                $dataApplications[$siteID][$appID]['itemID']        = $dataDB['id'];
                $dataApplications[$siteID][$appID]['maxRisk']       = $dataDB['riskMigValue'];
                $dataApplications[$siteID][$appID]['likeFrom']      = $dataDB['riskMigLikeFrom'];
                $dataApplications[$siteID][$appID]['likeTo']        = $dataDB['riskMigLikeTo'];
                
            }
        }
        
    }
    //var_dump($dataApplications);
    return $dataApplications; 
}

function calculateStakeHolder($employeeID, $activePhase){
    
    $dataBU       = array(); 
    $dataSite     = array();
    $dataAssets   = array();
    $dataHardware = array();
    $dataApp      = array();
    $siteMax      = array();
    
    $employeeConData = getStakeholderConnection($employeeID);
    foreach ($employeeConData as $employeeConIndex => $employeeConValue) {
        //var_dump($employeeConIndex);
        switch ($employeeConIndex) {
            case 'DutyByBU':
                $dataBU = getAllSitesFromBU($employeeConValue, $activePhase);
                //var_dump($dataBU);
                //var_dump($employeeConValue);
                break;
            case 'DutyBySite':
                $dataSite = stakeHolderGetSites($employeeConValue, $activePhase);
                //var_dump($dataSite);
                break;
            case 'assetBySerial':
                $dataAssets = stakeHolderGetAssets($employeeConValue, $activePhase);
                //var_dump($dataAssets);
                break;
            case 'DutyByHardware':
                $dataHardware = stakeholderGetHardvare($employeeConValue, $activePhase);
                //var_dump($dataHardware);
                break;
            case 'DutyByApp':
                $dataApp = stakeholderGetApplications($employeeConValue, $activePhase);
                //var_dump($dataApp);
                break;
            default:
                break;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    
    // FOR SITE
    foreach ($dataSite as $index => $value) {
        if (array_key_exists($index, $dataBU)) { unset($dataBU[$index]); }
        $siteMax[$index]['site']['maxRisk'] = $value['maxRisk'];
        $siteMax[$index]['site']['likeFrom'] = $value['likeFrom'];
        $siteMax[$index]['site']['likeTo'] = $value['likeTo']; 
        
    }
    
    
    // FOR BUSINESS UNIT
    foreach ($dataBU as $index => $value) {
        //if($siteMax[$index]['bu']['maxRisk'] < $value['maxRisk']){
            $siteMax[$index]['bu']['maxRisk'] = $value['maxRisk']; 
            $siteMax[$index]['bu']['likeFrom'] = $value['likeFrom'];  
            $siteMax[$index]['bu']['likeTo'] = $value['likeTo'];
        
    }
    
    // FOR ASSETS
    foreach ($dataAssets as $index => $valueSite) {
        foreach ($valueSite as $itemIndex => $itemValue) {
            
            if(array_key_exists($itemIndex, $dataHardware[$index])) {  unset($dataHardware[$index][$itemIndex]); }
            if(count($dataHardware[$index]) <= 0){ unset($dataHardware[$index]); }
            
            if($siteMax[$index]['assets']['maxRisk'] < $itemValue['maxRisk']){ $siteMax[$index]['assets']['maxRisk'] = $itemValue['maxRisk']; }
            
            if($siteMax[$index]['assets']['likeFrom'] == null) { $siteMax[$index]['assets']['likeFrom'] = $itemValue['likeFrom']; }
            if($siteMax[$index]['assets']['likeFrom'] >= $itemValue['likeFrom']){ $siteMax[$index]['assets']['likeFrom'] = $itemValue['likeFrom']; }

            if($siteMax[$index]['assets']['likeTo'] <= $itemValue['likeTo']){ $siteMax[$index]['assets']['likeTo'] = $itemValue['likeTo']; }
            
        }
        
    }
    //var_dump($dataHardware);
    // FOR HARDWARES
    foreach ($dataHardware as $index => $valueSite) {
        foreach ($valueSite as $itemIndex => $itemValue) { 
            if($siteMax[$index]['hardware']['maxRisk'] < $itemValue['maxRisk']){ $siteMax[$index]['hardware']['maxRisk'] = $itemValue['maxRisk']; }
            
            if($siteMax[$index]['hardware']['likeFrom'] == null) { $siteMax[$index]['hardware']['likeFrom'] = $itemValue['likeFrom']; }
            if($siteMax[$index]['hardware']['likeFrom'] >= $itemValue['likeFrom']){ $siteMax[$index]['hardware']['likeFrom'] = $itemValue['likeFrom']; }

            if($siteMax[$index]['hardware']['likeTo'] <= $itemValue['likeTo'] ){  $siteMax[$index]['hardware']['likeTo'] = $itemValue['likeTo']; }
        }
    }
    
    // FOR APPLICATIONS
    //array_column($dataHardware, '0');
    foreach ($dataApp as $index => $valueSite) {
        foreach ($valueSite as $itemIndex => $itemValue) { 
            if($siteMax[$index]['application']['maxRisk'] < $itemValue['maxRisk']) { $siteMax[$index]['application']['maxRisk'] = $itemValue['maxRisk']; }
            
            if($siteMax[$index]['application']['likeFrom'] == null) { $siteMax[$index]['application']['likeFrom'] = $itemValue['likeFrom']; }
            if($siteMax[$index]['application']['likeFrom'] >= $itemValue['likeFrom']) { $siteMax[$index]['application']['likeFrom'] = $itemValue['likeFrom']; }
    
            if($siteMax[$index]['application']['likeTo'] <= $itemValue['likeTo']) { $siteMax[$index]['application']['likeTo'] = $itemValue['likeTo']; } 
        }
    }
    
    return $siteMax;
    ///////////////////////////////////////////////////////////////////////////////////////////////////
}

function stakeholdersShowCalcBySites($employeeID, $activePhase) {
    $dataRiskSite = array();
    $stakeHolderRiskData = calculateStakeHolder($employeeID, $activePhase);
    foreach ($stakeHolderRiskData as $siteID => $typeOfDuty) {
        
        foreach ($typeOfDuty as $dutyName => $dutyValue)
        {
            
            if($dutyValue['maxRisk'] > 0 ){
                if($dataRiskSite[$siteID]['maxRisk'] < $dutyValue['maxRisk']) { $dataRiskSite[$siteID]['maxRisk'] = $dutyValue['maxRisk']; }
                if($dataRiskSite[$siteID]['likeFrom'] == null) { $dataRiskSite[$siteID]['likeFrom'] = $dutyValue['likeFrom']; }
                if($dataRiskSite[$siteID]['likeFrom'] >= $dutyValue['likeFrom']) { $dataRiskSite[$siteID]['likeFrom'] = $dutyValue['likeFrom']; }
                if($dataRiskSite[$siteID]['likeTo'] <= $dutyValue['likeTo']) { $dataRiskSite[$siteID]['likeTo'] = $dutyValue['likeTo']; }
            }
        }
        
    }
    return $dataRiskSite;
}

function insertRiskForStakeHodler($employeeID,$activePhase) {
    //deleteMigRisk($employeeID, 3);
    /*$sitesRisk = stakeholdersShowCalcBySites($employeeID, $activePhase);
    foreach ($sitesRisk as $siteID => $siteRiskValue) {
        $data = array();
        
        if($siteRiskValue['likeFrom'] != "") {
            $siteRiskValue['likeFrom'] = date('d/m/Y', $siteRiskValue['likeFrom']);
            //$siteRiskValue['likeFrom'] = strtotime(str_replace('/', '-', $siteRiskValue['likeFrom']));
        }
        
        if($siteRiskValue['likeTo']   != "") { 
            $siteRiskValue['likeTo'] = date('d/m/Y', $siteRiskValue['likeTo']);
            //$siteRiskValue['likeTo']   = strtotime(str_replace('/', '-', $siteRiskValue['likeTo'])); 
        }
        
        
        
        $data['migrationValue']          = $siteRiskValue['maxRisk'];
        $data['migrationLikelihoodFrom'] = $siteRiskValue['likeFrom'];
        $data['migrationLikelihoodTo']   = $siteRiskValue['likeTo'];
        $data['createdBy']               = $GLOBALS['userID'];
        $data['createdDate']             = $GLOBALS['lastUpdate'];
        //addNewMigRisk($employeeID, 3, $data, $siteID);
        
    }*/
    
    
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/****************************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getRiskItemTypes($id = null){
	$where = null;	
	if($id != null) { $where = " WHERE riskItemTypeID = '".$id."'"; }
    $sql = "SELECT * FROM tdbRiskItemTypes " .$where;
    $res = mysql_query($sql);
    $typeData = array();
    //$i = 1;
    
    while($row = mysql_fetch_array($res)){
        
        $typeData[$row['riskItemTypeID']]['riskItemTypeID']      = $row['riskItemTypeID'];
        $typeData[$row['riskItemTypeID']]['riskTypeName']        = $row['riskTypeName']; 
        $typeData[$row['riskItemTypeID']]['riskTypeCoef']        = $row['riskTypeCoef'];
        $typeData[$row['riskItemTypeID']]['riskTypeNormalRatio'] = $row['riskTypeNormalRatio']; 
        
        //$i++;
    }
    
    return $typeData;
}

//function getStakeholderDataBySite($siteID){
function countRiskAutoBySite($siteID) { 
    $stakeholderResult;
    /*$sql = " OR (ap.siteID   = '" . $siteID . "') ";*/
    $riskTypes = getRiskItemTypes();
    $sql = "SELECT ec.employeeID as employeeID, a.nodeID as assetNode, atd.nodeID as hardwareNode, sb.siteID as siteIDBU, s.siteID as siteID, ap.id as appID  
            FROM tdbEmployeeConnection ec 
            LEFT JOIN tdbAssetsDeviceTable a ON ec.objectID = a.nodeID AND ec.connectionType = 'assetBySerial' AND a.siteID = '" . $siteID . "' 
            LEFT JOIN tdbAssetType ata ON ec.objectID = ata.assetTypeID AND ec.connectionType = 'DutyByHardware' 
            LEFT JOIN tdbAssetsDeviceTable atd ON ata.assetTypeName = atd.systemType AND atd.siteID = '" . $siteID . "' 
            LEFT JOIN tdbSite sb ON ec.objectID = sb.siteBusinessunitID AND ec.connectionType = 'DutyByBU' AND sb.siteID = '" . $siteID . "' 
            LEFT JOIN tdbSite s ON ec.objectID = s.siteID AND ec.connectionType = 'DutyBySite' AND s.siteID = '" . $siteID . "' 
            LEFT JOIN tdbAIApplication ap ON ec.objectID = ap.id AND ec.connectionType = 'DutyByApp' AND ap.siteID = '" . $siteID . "' 
            WHERE ((a.siteID = '" . $siteID . "') 
            OR (sb.siteID = '" . $siteID . "') 
            OR (atd.siteID = '" . $siteID . "') 
            OR (s.siteID = '" . $siteID . "') 
            OR (ap.siteID = '" . $siteID . "'))";
    
    $res = mysql_query($sql);
    // FILL Stakeholder Connection Data (Assets, Hardwares, Application, Sites)
    if($res) {
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $type = null;
            $value = null;
            
            if($row['employeeID'] != null){
                if($row['assetNode'] != null OR $row['hardwareNode'] != null){
                    $type = 1;
                    $value = null;
                    if($row['assetNode'] != null)   { $value = $row['assetNode']; }
                    if($row['hardwareNode'] != null) { $value = $row['hardwareNode']; }
                }
                if($row['appID'] != null) { $type = 6; $value = $row['appID']; }
                if($row['siteIDBU'] != null OR $row['siteID']) {
                    $type = 'site';
                    if($row['siteIDBU'] != null) { $value = $row['siteIDBU']; }
                    if($row['siteID'] != null)   { $value = $row['siteID']; }
                }
                if($type != null AND $value != null){
                    $stakeholderResult[$type][$value] = $value;
                    //var_dump($value); echo  '</hr>';
                    $i++;
                }
                
            }
        }
    }
    
    $stakeholderRiskItems = array();
	
	// Get All 
    $allSiteRiskItems  = getMigDataBySiteForStake($siteID); // All Data Whose Have Migration Risk On This Site
    $stakeholderSearch = $allSiteRiskItems;           // Will be data only whose have migration for connection of stakeholders on this site 
    
    $stakeholderRiskData = array();
    
    // REMOVE ELEMENT WHOSE NOT IN CONNECTION (Because we need calc whole "site" and then calc "Stakehodler" MAX data and + with site MAX
    $calcSite = array();
    foreach ($stakeholderSearch as $stakeholderIndex => $stakeholdersValue) {
        if(!array_key_exists($stakeholderIndex, $stakeholderResult)){
            unset($stakeholderSearch[$stakeholderIndex]);
        }else{
            foreach ($stakeholderValue as $stInd => $stVal){
                if(!array_key_exists($stInd, $stakeholderResult[$stakeholderIndex])){
                    unset($stakeholderSearch[$stakeholderIndex][$stInd]);
                }
            }
        }
        
    }
	
    // FOR SITE CALC
    $calcSite = array(); //SiteData
    $maxSH = array(); // Max calc For stakeholder
    
    foreach ($allSiteRiskItems as $typeIndex => $typeVal) {
        foreach ($typeVal as $itemID => $itemValue)
        {
            if($typeIndex != 3 and $typeIndex != 100){
                if($calcSite['data'][$typeIndex]['maxRisk'] < $itemValue['maxRisk'])   { $calcSite['data'][$typeIndex]['maxRisk'] = $itemValue['maxRisk']; }
                if($calcSite['data'][$typeIndex]['minLike'] == null)                   { $calcSite['data'][$typeIndex]['minLike'] = $itemValue['likeFrom']; }
                if($calcSite['data'][$typeIndex]['minLike'] >= $itemValue['likeFrom']) { $calcSite['data'][$typeIndex]['minLike'] = $itemValue['likeFrom']; }
                if($calcSite['data'][$typeIndex]['maxLike'] <= $itemValue['likeTo'])   { $calcSite['data'][$typeIndex]['maxLike'] = $itemValue['likeTo']; }
				
                $calcSite['data'][$typeIndex]['riskMigType']  = $typeIndex;
                $calcSite['data'][$typeIndex]['dataType']     = $riskTypes[$typeIndex]['riskTypeName'];  
                $calcSite['data'][$typeIndex]['riskTypeCoef'] = $riskTypes[$typeIndex]['riskTypeCoef'];
            }
			//echo $typeIndex . '<br>';
            
        }
		$maxSH['maxRisk'] += ($calcSite['data'][$typeIndex]['maxRisk'] * $calcSite['data'][$typeIndex]['riskTypeCoef']); 
        if($maxSH['minLike'] == null)                                     { $maxSH['minLike'] = $calcSite['data'][$typeIndex]['minLike']; }
        if($maxSH['minLike'] >= $calcSite['data'][$typeIndex]['minLike']) { $maxSH['minLike'] = $calcSite['data'][$typeIndex]['minLike']; }
        if($maxSH['maxLike'] <= $calcSite['data'][$typeIndex]['maxLike']) { $maxSH['maxLike'] = $calcSite['data'][$typeIndex]['maxLike']; }
        //echo $typeIndex;  
    }    
    
    // FOR STAKEHOLDER CALC
    $calcSH = array();
    foreach ($stakeholderSearch as $typeIndex => $typeValue) {
    	//echo $typeIndex;
        foreach ($typeVal as $itemID => $itemValue) {
            if($calcSH['data'][3]['maxRisk'] < $itemValue['maxRisk'])   { $calcSH['data'][3]['maxRisk'] = $itemValue['maxRisk']; }
            if($calcSH['data'][3]['minLike'] == null)                   { $calcSH['data'][3]['minLike'] = $itemValue['likeFrom']; }
            if($calcSH['data'][3]['minLike'] >= $itemValue['likeFrom']) { $calcSH['data'][3]['minLike'] = $itemValue['likeFrom']; }
            if($calcSH['data'][3]['maxLike'] <= $itemValue['likeTo'])   { $calcSH['data'][3]['maxLike'] = $itemValue['likeTo']; }
            //$calcSH['data'][3]['riskMigType'] = $typeIndex;
        }
    }
	
	//var_dump($stakeholderResult['site'][$siteID] );
	// Check IF Site is Connected (if connected check if site > stakeholder)
	if($stakeholderResult['site'][$siteID] != null) {
		if($calcSH['data'][3]['maxRisk'] < $maxSH['maxRisk'])  { $calcSH['data'][3]['maxRisk'] = $maxSH['maxRisk']; }
		if($calcSH['data'][3]['minLike'] == null)              { $calcSH['data'][3]['minLike'] = $maxSH['minLike']; }
		if($calcSH['data'][3]['minLike'] >= $maxSH['minLike']) { $calcSH['data'][3]['minLike'] = $maxSH['minLike']; }
		if($calcSH['data'][3]['maxLike'] <= $maxSH['maxLike']) { $calcSH['data'][3]['maxLike'] = $maxSH['maxLike']; }	
	}
	//$calcSH['data'][3]['maxRisk'] 
	
	// Check For Max Data For Site
	$maxSH['maxRisk'] += $calcSH['data'][3]['maxRisk'] * $riskTypes[3]['riskTypeCoef'];
	if($maxSH['minLike'] == null) { $maxSH['minLike'] = $calcSH['data'][3]['minLike']; }
	if($maxSH['minLike'] > $calcSH['data'][3]['minLike']){ $maxSH['minLike'] = $calcSH['data'][3]['minLike']; }
	if($maxSH['maxLike'] > $calcSH['data'][3]['maxLike']){ $maxSH['maxLike'] = $calcSH['data'][3]['maxLike']; }
	
	// ADD Stakeholder To SITE
	$calcSH['data'][3]['riskMigType']  = 3;
    $calcSH['data'][3]['dataType']     = $riskTypes[3]['riskTypeName'];  
    $calcSH['data'][3]['riskTypeCoef'] = $riskTypes[3]['riskTypeCoef'];
	
	// Set All To Site
	$calcSite['data'][3] = $calcSH['data'][3];
	
	$calcSite['risk']['coef']    = $maxSH['maxRisk'];
	$calcSite['risk']['minLike'] = $maxSH['minLike'];
	$calcSite['risk']['maxLike'] = $maxSH['maxLike'];
	$calcSite['riskTypes'] = $riskTypes;
	
	return $calcSite;
    //return $stakeholderSearch;
}

function getMigDataBySiteForStake ($siteID) { 
    $data = array();
    $sql = "SELECT rd.riskMigExternalID, rd.riskMigType, rd.riskMigValue, rd.riskMigLikeFrom, rd.riskMigLikeTo, rt.riskTypeName, rt.riskTypeCoef
            FROM tdbRiskMigrationData rd 
            JOIN tdbRiskItemTypes rt ON rd.riskMigType = rt.riskItemTypeID

            WHERE rd.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m 
            WHERE rd.riskMigExternalID = m.riskMigExternalID AND rd.riskMigSiteID ='" . $siteID . "' AND rd.riskMigType = m.riskMigType) AND rd.riskMigSiteID ='" . $siteID . "' ";
            
    $res = mysql_query($sql);
    if($res) {

        while ($row = mysql_fetch_array($res)) {
            $data[$row['riskMigType']][$row['riskMigExternalID']]['maxRisk']      = $row['riskMigValue'];
            $data[$row['riskMigType']][$row['riskMigExternalID']]['likeFrom']     = $row['riskMigLikeFrom'];
            $data[$row['riskMigType']][$row['riskMigExternalID']]['likeTo']       = $row['riskMigLikeTo'];
            $data[$row['riskMigType']][$row['riskMigExternalID']]['riskTypeName'] = $row['riskTypeName'];
            $data[$row['riskMigType']][$row['riskMigExternalID']]['riskTypeCoef'] = $row['riskTypeCoef'];
          
        }
    }
    
    return $data;
}


function getAllStakeholdersBySite($siteID) {
    //ini_set('display_error', 1);
    $riskTypes = getRiskItemTypes();
    $stakeholderConData = array();
    $stakeholderSite = array();
    $stakeholderNames = array();
    
    // Initialize variables
    $stakeholderRiskItems = array();
    $allSiteRiskItems     = getMigDataBySiteForStake($siteID); // All Data Whose Have Migration Risk On This Site
    
    $pdoCon = new PDO('mysql:host=localhost;dbname=tdb4db', 'root','Vc@2o13TMP');
    $sql = "SELECT ec.employeeID as employeeID, e.employeeFullName, a.nodeID as assetNode, atd.nodeID as hardwareNode, sb.siteID as siteIDBU, s.siteID as siteID, ap.id as appID  
        FROM tdbEmployeeConnection ec   
        LEFT JOIN tdbTMPEmployee e ON ec.employeeID = e.employeeID
        LEFT JOIN tdbAssetsDeviceTable a ON ec.objectID = a.nodeID AND ec.connectionType = 'assetBySerial' AND a.siteID = '" . $siteID . "' 
        LEFT JOIN tdbAssetType ata ON ec.objectID = ata.assetTypeID AND ec.connectionType = 'DutyByHardware' 
        LEFT JOIN tdbAssetsDeviceTable atd ON ata.assetTypeName = atd.systemType AND atd.siteID = '" . $siteID . "' 
        LEFT JOIN tdbSite sb ON ec.objectID = sb.siteBusinessunitID AND ec.connectionType = 'DutyByBU' AND sb.siteID = '" . $siteID . "' 
        LEFT JOIN tdbSite s ON ec.objectID = s.siteID AND ec.connectionType = 'DutyBySite' AND s.siteID = '" . $siteID . "' 
        LEFT JOIN tdbAIApplication ap ON ec.objectID = ap.id AND ec.connectionType = 'DutyByApp' AND ap.siteID = '" . $siteID . "' 
        WHERE ((a.siteID = '" . $siteID . "') 
        OR (sb.siteID = '" . $siteID . "') 
        OR (atd.siteID = '" . $siteID . "') 
        OR (s.siteID = '" . $siteID . "') 
        OR (ap.siteID = '" . $siteID . "'))";
            
    $data = $pdoCon->query($sql);
	//$employeeID ;
    foreach($data as $row){
		//$employeeID[$row['employeeID']] = $row['employeeID'];
		$type = null;
        $value = null;
        
        if($row['employeeID'] != null){
            if($row['assetNode'] != null OR $row['hardwareNode'] != null){
                $type = 1;
                $value = null;
                if($row['assetNode'] != null)   { $value = $row['assetNode']; }
                if($row['hardwareNode'] != null) { $value = $row['hardwareNode']; }
            }
            if($row['siteIDBU'] != null OR $row['siteID']) {
                if($row['siteIDBU'] != null) { $stakeholderSite[$row['siteIDBU']] = $row['siteIDBU']; }
                if($row['siteID'] != null)   { $stakeholderSite[$row['siteID']]   = $row['siteID']; }
            }
            if($row['appID'] != null) { $type = 6; $value = $row['appID']; }
            
            if($type != null AND $value != null){
            	if(array_key_exists($value, $allSiteRiskItems[$type])){
                	$stakeholderConData[$row['employeeID']][$type][$value] = array();
					$stakeholderNames[$row['employeeID']] = $row['employeeFullName'];
                	$i++;
				}
            }
            
        }
    }
	
    
	
	
	// FOR SITE CALC
    $calcSite = array(); //SiteData
    $maxSH = array(); // Max calc For stakeholder
    
    foreach ($allSiteRiskItems as $typeIndex => $typeVal) {
        foreach ($typeVal as $itemID => $itemValue)
        {
            if($typeIndex != 3 and $typeIndex != 100){
                if($calcSite['data'][$typeIndex]['maxRisk'] < $itemValue['maxRisk'])   { $calcSite['data'][$typeIndex]['maxRisk'] = $itemValue['maxRisk']; }
                if($calcSite['data'][$typeIndex]['minLike'] == null)                   { $calcSite['data'][$typeIndex]['minLike'] = $itemValue['likeFrom']; }
                if($calcSite['data'][$typeIndex]['minLike'] >= $itemValue['likeFrom']) { $calcSite['data'][$typeIndex]['minLike'] = $itemValue['likeFrom']; }
                if($calcSite['data'][$typeIndex]['maxLike'] <= $itemValue['likeTo'])   { $calcSite['data'][$typeIndex]['maxLike'] = $itemValue['likeTo']; }
				
                $calcSite['data'][$typeIndex]['riskMigType']  = $typeIndex;
                $calcSite['data'][$typeIndex]['dataType']     = $riskTypes[$typeIndex]['riskTypeName'];  
                $calcSite['data'][$typeIndex]['riskTypeCoef'] = $riskTypes[$typeIndex]['riskTypeCoef'];
            }
			//echo $typeIndex . '<br>';
            
        }
		$maxSH['maxRisk'] += ($calcSite['data'][$typeIndex]['maxRisk'] * $calcSite['data'][$typeIndex]['riskTypeCoef']); 
        if($maxSH['minLike'] == null)                                     { $maxSH['minLike'] = $calcSite['data'][$typeIndex]['minLike']; }
        if($maxSH['minLike'] >= $calcSite['data'][$typeIndex]['minLike']) { $maxSH['minLike'] = $calcSite['data'][$typeIndex]['minLike']; }
        if($maxSH['maxLike'] <= $calcSite['data'][$typeIndex]['maxLike']) { $maxSH['maxLike'] = $calcSite['data'][$typeIndex]['maxLike']; }
        //echo $typeIndex;  
    }
	
	
	$stakeholderDatas = array();
	// Stakeholder Clean Data
	foreach($stakeholderConData as $stakeholderID => $stakeholderData) {
		foreach($stakeholderData as $riskType => $riskTypeData) {
			
			if(!array_key_exists($riskType, $allSiteRiskItems)) { // Check if risk type exists in stakeholder connections 
				unset($stakeholderConData[$stakeholderID][$riskType]);
			} else {
				foreach($riskTypeData as $riskItemID => $riskItemData) { // check if risk item exists if dont removi it from memory if exists give con data value of risk 
					//echo $riskItemID . "<hr>";
					if(!array_key_exists($riskItemID, $allSiteRiskItems[$riskType])){
						unset($stakeholderConData[$stakeholderID][$riskType][$riskItemID]);
					} else {
						if($stakeholderDatas[$stakeholderID][$riskType]['maxRisk'] < $allSiteRiskItems[$riskType][$riskItemID]['maxRisk']) {
						$stakeholderDatas[$stakeholderID][$riskType]['maxRisk']      = $allSiteRiskItems[$riskType][$riskItemID]['maxRisk']; }
						
						if($stakeholderDatas[$stakeholderID][$riskType]['likeFrom'] == null){
						$stakeholderDatas[$stakeholderID][$riskType]['likeFrom']     = $allSiteRiskItems[$riskType][$riskItemID]['likeFrom']; }
						
						if($stakeholderDatas[$stakeholderID][$riskType]['likeFrom'] >= $allSiteRiskItems[$riskType][$riskItemID]['likeFrom']) {
						$stakeholderDatas[$stakeholderID][$riskType]['likeFrom']     = $allSiteRiskItems[$riskType][$riskItemID]['likeFrom']; }
						
						if($stakeholderDatas[$stakeholderID][$riskType]['likeTo'] <= $allSiteRiskItems[$riskType][$riskItemID]['likeTo']) {
						$stakeholderDatas[$stakeholderID][$riskType]['likeTo']     = $allSiteRiskItems[$riskType][$riskItemID]['likeTo']; }
						// set coef for counting 
						//$stakeholderDatas[$stakeholderID][$riskType]['riskTypeName'] = $allSiteRiskItems[$riskType][$riskItemID]['riskTypeName'];
						//$stakeholderDatas[$stakeholderID][$riskType]['riskTypeCoef'] = $allSiteRiskItems[$riskType][$riskItemID]['riskTypeCoef'];
					}
					
					if($stakeholderDatas[$stakeholderID][$riskType]['maxRisk'] != null) {
						if($stakeholderDatas[$stakeholderID]['maxRisk'] < $stakeholderDatas[$stakeholderID][$riskType]['maxRisk']) {
						$stakeholderDatas[$stakeholderID]['maxRisk'] = $stakeholderDatas[$stakeholderID][$riskType]['maxRisk']; }
						
						if($stakeholderDatas[$stakeholderID]['likeFrom'] == null) {
						$stakeholderDatas[$stakeholderID]['likeFrom'] = $stakeholderDatas[$stakeholderID][$riskType]['likeFrom']; }
						if($stakeholderDatas[$stakeholderID]['likeFrom'] >= $stakeholderDatas[$stakeholderID][$riskType]['likeFrom']) {
						$stakeholderDatas[$stakeholderID]['likeFrom'] = $stakeholderDatas[$stakeholderID][$riskType]['likeFrom']; }
						
						if($stakeholderDatas[$stakeholderID]['likeTo'] <= $stakeholderDatas[$stakeholderID][$riskType]['likeTo']) {
						$stakeholderDatas[$stakeholderID]['likeTo'] = $stakeholderDatas[$stakeholderID][$riskType]['likeTo']; }
						unset($stakeholderDatas[$stakeholderID][$riskType]);
					}
					
				}
			}
			
		}
		
	}
	
	// Remove from memory
	unset($allSiteRiskItems);
	unset($stakeholderConData);
	
	$riskData = array();
	// Calculate Stakeholder with site
	foreach($stakeholderDatas as $stakeholderID => $stakeholderRiskData) {
		if(array_key_exists($stakeholderID, $stakeholderSite)) {
			if($stakeholderDatas[$stakeholderID]['maxRisk'] < $maxSH['maxRisk'])    { $stakeholderDatas[$stakeholderID]['maxRisk'] = $maxSH['maxRisk']; }
			if($stakeholderDatas[$stakeholderID]['likeFrom'] == null )              { $stakeholderDatas[$stakeholderID]['likeFrom'] = $maxSH['likeFrom']; }
			if($stakeholderDatas[$stakeholderID]['likeFrom'] >= $maxSH['likeFrom']) { $stakeholderDatas[$stakeholderID]['likeFrom'] < $maxSH['likeFrom']; }
			if($stakeholderDatas[$stakeholderID]['likeTo'] <= $maxSH['likeTo'])     { $stakeholderDatas[$stakeholderID]['likeTo'] < $maxSH['likeTo']; }
		}
		$stakeholderDatas[$stakeholderID]['name'] = $stakeholderNames[$stakeholderID];
		//if($riskData['maxRisk'] < $stakeholderDatas[$stakeholderID]['maxRisk']) { $riskData['maxRisk'] < $stakeholderDatas[$stakeholderID]['maxRisk']; }
		
	}
	
	
	// Check if stakeholder have site
	
	
	
	
	
	
	
	return $stakeholderDatas; 
}




?>
