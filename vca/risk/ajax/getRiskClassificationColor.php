<?php 
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$sliderValue = $_GET['sliderValue'];
	
	if($sliderValue == 0)
	{
		$sliderValue = " <= " . $sliderValue;
	}elseif($sliderValue > 0)
	{
		$sliderValue = " < " . $sliderValue;
	}
	
	
	$sql = "SELECT riskClassificationColor FROM tdbRiskClassification WHERE riskValue". $sliderValue . " LIMIT 0,1";
	$res = mysql_query($sql);
	
	while($data = mysql_fetch_array($res))
	{
		echo $data['riskClassificationColor'];
	}

?>