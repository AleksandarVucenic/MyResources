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
			
			`riskLikelihoodComment`='$dataPost->riskLikelihoodNotes',
			`riskLikelihoodPercent`='$dataPost->riskLikelihoodPercenteForm',
			`riskLikelihoodFromTime`='$dataPost->riskLikelihoodFromForm',
			`riskLikelihoodToTime`='$dataPost->riskLikelihoodToForm',
		";
		//var_dump($dataPost);
		if($action == "save")
		{
			$data .= "
				`createdBy`='$userID',
				`createdDate`='$lastUpdate'
			";				
			$sql = "INSERT INTO `tdbRiskLikelihood` SET $data";
			$messageTask=" saved ";	
		}
		
		if($action == "update")
		{
			
			$data .= "
				`userID`='$userID',
				`lastUpdate`='$lastUpdate'
			";					
			$sql = "UPDATE `tdbRiskLikelihood` SET $data WHERE riskLikelihoodID=".$_POST['riskLikelihoodIDForm'];	
			$messageTask=" updated ";
		}
		$res = mysql_query($sql);
		
		if($res){
			$messageStatus = "Successful $messageTask risk type!";
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
		echo $sql = "DELETE FROM `tdbRiskLikelihood` WHERE riskLikelihoodID=".$_GET['riskLikelihoodID'];
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
		$sql = " SELECT * FROM `tdbRiskLikelihood` WHERE riskLikelihoodID=".$_GET['riskLikelihoodID']. " LIMIT 0,1";
		$res = mysql_query($sql);
		
		//var_dump(mysql_num_rows($res));
		$dataJS = array();
		while($data =  mysql_fetch_array($res)){
			$dataJS['riskLikelihoodIDForm']        = $data['riskLikelihoodID'];
			$dataJS['riskLikelihoodNotes']         = $data['riskLikelihoodComment'];
			$dataJS['riskLikelihoodPercenteForm']  = $data['riskLikelihoodPercent'];
			$dataJS['riskLikelihoodFromForm']      = $data['riskLikelihoodFromTime'];
			$dataJS['riskLikelihoodToForm']        = $data['riskLikelihoodToTime'];
		}
		//var_dump($dataJS);
		echo json_encode($dataJS);
	}


?>