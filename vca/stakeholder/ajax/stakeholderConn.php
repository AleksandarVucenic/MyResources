<?php 
	session_start(); 
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

	$connType = $_GET["connType"];
	
	switch ($connType) {
		case 'APP':
			$table = "tdbAIApplication";
			$id = "id";
			$name = "name";
			$phase = "AND a.`projectPhaseID` = $activePhase";
			$info = "ShowAppInfo";
			break;
		case 'ASSET':
			$table = "tdbAssetsDeviceTable";
			$id = "nodeID";
			$name = "deviceName";
			$phase = "AND a.`projectPhaseID` = $activePhase";
			$info = "ShowAssetInfoSearch";
			break;
		case 'BU':
			$table = "tdbBusinessUnit";
			$id = "businessUnitID";
			$name = "businessUnitName";
			$phase = "";
			$info = "ShowBUInfo";
			break;
		case 'HW':
			$table = "tdbAssetType";
			$id = "assetTypeID";
			$name = "assetTypeName";
			$phase = "";
			$info = "ShowHWInfo";
			break;
		case 'SITE':
			$table = "tdbSite";
			$id = "siteID";
			$name = "siteName";
			$phase = "AND a.`projectPhaseID` = $activePhase";
			$info = "ShowSiteInfo1";
			break;
		case 'SW':
			$table = "software";
			$id = "software_id";
			$name = "software_name";
			$phase = "";
			$info = "ShowSWInfo";
			break;
		
	}
	
	$sql = "SELECT * FROM `$table` a 
			INNER JOIN `tdbEmployeeConnection` b 
			ON a.$id = b.`objectID`
			WHERE b.`description` = '$connType'
			$phase
			GROUP BY b.`objectID`";
	//echo $sql;
			
	$res = mysql_query($sql);
?>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
 	<tr class="table_header">
    	<td align="left">Name</td>
    </tr>
</table>
<div align="center" class="ajaxbox" style="overflow-y: scroll;min-height: 200px;max-height: 200px;display: block;">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<?php 
	while($row = mysql_fetch_array($res)){
		$connID = $row["$id"];
		$connName = $row["$name"];
		
		echo "<tr class='whitebg' style='cursor: pointer'>
				<td onclick=\"displayEmployee($connID, '$connName', '$connType')\" align='left'>
					<a class=\"tooltipFix\" style=\"padding:3px;width:100%\">
						$connName
						<span class='classic info'>
							<img src='/images/Info.png' alt='Information' />
							<em>Info</em>
							";echo $info($connID);"
						</span>
					</a>
				</td>
			</tr>";
	}
?>   
</table> 
</div>
