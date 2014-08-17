<?php 
	session_start(); 
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	include($_SERVER['DOCUMENT_ROOT']."/managetpc/risk/helepers/functions.php"); 
	$connID = $_GET["connID"];
	$connName = $_GET["connName"];
	$connType = $_GET["connType"];
	
	$sql = "SELECT * FROM `tdbEmployeeConnection` 
			WHERE `description` = '$connType'
			AND `objectID` = $connID";
			
	$res = mysql_query($sql);
?>
<fieldset><legend>Stakeholders on <label class="orange"><?php echo $connName; ?></label></legend>
<table style="margin-top: 23px;" width="100%" cellpadding="2" cellspacing="0" border="0">
 	<tr class="table_header">
    	<td width="150px" align="left">Name</td>
    	<td width="150px" align="left">Company</td>
    	<td align="left">Role</td>
    	<td align="center"> Risk</td>
    </tr>
</table>
<div align="center" class="ajaxbox" style="overflow-y: scroll;min-height: 200px;max-height: 200px;display: block;">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<?php 
	while($row = mysql_fetch_array($res)){
		$empID = $row["employeeID"];
		$empName = displayEmployee($empID);
		
		$sql1 = "SELECT companyID, roleID, businessUnitID
					FROM `tdbTMPEmployee`
					WHERE `employeeID` = $empID";
		$res1 = mysql_query($sql1);
		$row1 = mysql_fetch_array($res1);
		$empCompany = displayCompany($row1["companyID"]);
		$empRole = displayRole($row1["roleID"]);
		
		echo "<tr style='cursor:pointer;'  class='whitebg'>
				<td title='View employee details' width='150px' align='left' onclick=\"window.open('/employee/?a=company&action=view&row=$empID')\" >$empName</td>
				<td title='View employee details' width='150px' align='left' onclick=\"window.open('/employee/?a=company&action=view&row=$empID')\" >$empCompany</td>
				<td title='View employee details' align='left' onclick=\"window.open('/employee/?a=company&action=view&row=$empID')\" >$empRole</td>
				<td align='center'> <img style='width: 25px;' src='/images/migRisk.png' alt='Show Migration Risk' onclick=\"showStakeholderRiskMigrtion('$empID');\"  /> </td>
			</tr>";
	}
?>   
</table>
</div> 
</fieldset>
