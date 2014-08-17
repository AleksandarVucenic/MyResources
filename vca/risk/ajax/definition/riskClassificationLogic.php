<?php 

	//var_dump($_POST);
	
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	
	$userID = $_SESSION['userID'];
	$action = $_GET['action'];
	
	/* SAVE & UPDATE
	 * =================================================================
	 **/
	if($action == "update" OR $action == "save")
	{
		$dataPost = (object) $_POST;
		
		$data = "
			
			`riskName`='$dataPost->riskNameForm',
			`riskComment`='$dataPost->riskCommentForm',
			`riskLevel`='$dataPost->riskLevelForm',
			`riskCost`='$dataPost->riskCostForm',
			`riskCostGrade`='$dataPost->riskCostGradeForm',
			`riskValue`='$dataPost->riskValueForm',
			`riskClassificationColor`='$dataPost->riskColorForm',
			`riskCurrency` = '$dataPost->currencyID',
		";
		//var_dump($dataPost);
		if($action == "save")
		{
			$data .= "
				`riskCreatedBy`='$userID',
				`riskCreatedDate`='$lastUpdate'
			";				
			$sql = "INSERT INTO `tdbRiskClassification` SET $data";
			$messageTask=" saved ";	
		}
		
		if($action == "update")
		{
			
			$data .= "
				`riskUserID`='$userID',
				`riskLastUpdate`='$lastUpdate'
			";					
			$sql = "UPDATE `tdbRiskClassification` SET $data WHERE `riskID` = ".$_POST['riskIDForm'];	
			$messageTask=" updated ";
		}
		$res = mysql_query($sql);
		
		if($res){
			$messageStatus = "Successful $messageTask risk classificatoin!";
		}else{
			$messageStatus = "Unsuccessfull request !";
		}
		
		echo '<script type="text/javascript">showOverlayMessage("'.$messageStatus.'", "warning", true); </script>';
		
	}
	
	
	/* DELETE
	 * =================================================================
	 **/
	if($action == "delete") 
	{
		$sql = "DELETE FROM `tdbRiskClassification` WHERE ``riskID=".$_GET['riskID'];
		$res = mysql_query($sql);
		
		if($res) 
		{
			$messageStatus = "Succesfull deleted risk classification!";	
		}else{
			$messageStatus = "Unsuccessfull deleted risk classification!";
		}
		
		echo '<script type="text/javascript">showOverlayMessage("'.$messageStatus.'", "warning", true); </script>';
	}

	/* EDIT
	 * =================================================================
	 **/
	if($action == "edit") 
	{
		$sql = " SELECT * FROM `tdbRiskClassification` WHERE riskID = ".$_GET['riskID']. " LIMIT 0,1";
		$res = mysql_query($sql);
		
		//var_dump(mysql_num_rows($res));
		$dataJS = array();
		while($data =  mysql_fetch_array($res)){
			$dataJS['riskIDForm']        = $data['riskID'];
			$dataJS['riskNameForm']      = $data['riskName'];
			$dataJS['riskCommentForm']   = $data['riskComment'];
			$dataJS['riskLevelForm']     = $data['riskLevel'];
			$dataJS['riskCostForm']      = $data['riskCost'];
			$dataJS['riskCostGradeForm'] = $data['riskCostGrade'];
			$dataJS['riskValueForm']     = $data['riskValue'];
			$dataJS['riskColorForm']     = $data['riskClassificationColor'];
			$dataJS['currencyID']        = $data['riskCurrency'];
		}
		//var_dump($dataJS);
		echo json_encode($dataJS);
	}


?>