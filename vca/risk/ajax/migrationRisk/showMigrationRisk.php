<?php 
	
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$typeID     = $_POST['typeID'];
	$itemID = $_POST['itemID']; 
	
	//var_dump($_POST);
	
        $data = array('migrationValue' => 0);
        
	$sql = " SELECT r.* FROM `tdbRiskMigrationData` as r 
		     WHERE r.createdDate = ( SELECT max(m.createdDate) FROM `tdbRiskMigrationData` AS m WHERE m.riskMigExternalID = $itemID AND m.riskMigType = $typeID) AND  r.riskMigType = $typeID";
	$res = mysql_query($sql);
	
	$data = array();
	while($row = mysql_fetch_array($res))
	{
		$data['migrationValue']   = $row['riskMigValue'];
		$data['migrationComment'] = $row['riskMigComment'];
		$data['outputRisk']       = $row['riskMigValue'] .'%';
		
		if($row['riskMigLikeFrom'] != "" AND $row['riskMigLikeFrom'] != 0) { $data['migrationLikelihoodFrom'] = date('d/m/Y', $row['riskMigLikeFrom']); }
		if($row['riskMigLikeTo']   != "" AND $row['riskMigLikeTo'] != 0)   { $data['migrationLikelihoodTo']   = date('d/m/Y', $row['riskMigLikeTo']); }
		
		
	}
	
        if($data['migrationValue'] == "" OR $data['migrationValue'] == NULL) {
                $data['migrationValue'] = 0;
                $data['outputRisk']     = '0%';
        }
        
        if($data['migrationComment'] == "" ){ $data['migrationComment'] = ""; }
        if($data['migrationLikelihoodFrom'] == "" ){ $data['migrationLikelihoodFrom'] = ""; }
        if($data['migrationLikelihoodTo']   == "" ){ $data['migrationLikelihoodTo'] = ""; }
        
	echo json_encode($data);
?>