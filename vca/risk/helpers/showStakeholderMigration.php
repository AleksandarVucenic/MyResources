<?php 
	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	include($_SERVER['DOCUMENT_ROOT']."/managetpc/risk/helpers/functions.php"); 
	
	/*if(isset($_POST['action'])) {
		if($_POST['action'] == 'getStakeHolderMigData') {
			
			
			$data = calculateStakeHolder(33, 1);
			
			
			
		}
	}*/
	
	$data = calculateStakeHolder($_GET['employeeID'], $activePhase);
	
	/*$buMax        = max($data['bu']['maxRisk']);
	$siteMax        = max($data['site']['maxRisk']);
	$assetMax       = max($data['assets']['maxRisk']);
	$hardwareMax    = max($data['hardware']['maxRisk']);
	$applicationMax = max($data['application']['maxRisk']);*/
	
	$maxTotal = 0;
	
?>
<div id="migrationInfoContainer" class="add-new  overlay " >
     <div class="container">
         <div class="inner-container">
			<table  width="100%" cellpadding="2" cellspacing="0" border="0">
				<tr class="table_header">
					<td> SiteName </td>
					<td> Business Units </td> 
					<td> Site </td>
					<td> Assets </td>
					<td> Hardware </td>
					<td> Applications </td>
					<td> MAX </td>
				</tr>
				<?php foreach($data as $site => $siteVal) : ?>
				<?php // Count for each site 
					$maxSite = 0;
					if($siteVal['bu']['maxRisk']          > $maxSite) { $maxSite = $siteVal['bu']['maxRisk']; }
					if($siteVal['site']['maxRisk']        > $maxSite) { $maxSite = $siteVal['site']['maxRisk']; }
					if($siteVal['assets']['maxRisk']      > $maxSite) { $maxSite = $siteVal['assets']['maxRisk']; }
					if($siteVal['hardware']['maxRisk']    > $maxSite) { $maxSite = $siteVal['hardware']['maxRisk']; }
					if($siteVal['application']['maxRisk'] > $maxSite) { $maxSite = $siteVal['application']['maxRisk']; }
					
					if($maxSite > $maxTotal) { $maxTotal = $maxSite; }
				?>
				<tr>
					<td><?php if(displaySiteName($site) != "")             { echo displaySiteName($site); }else{ echo 0; }?></td>
					<td><?php if($siteVal['bu']['maxRisk'] != "")          { echo $siteVal['bu']['maxRisk']; }else{ echo 0; }?> %</td>
					<td><?php if($siteVal['site']['maxRisk'] != "")        { echo $siteVal['site']['maxRisk']; }else{ echo 0; }?> %</td>
					<td><?php if($siteVal['assets']['maxRisk'] != "")      { echo $siteVal['assets']['maxRisk']; }else{ echo 0; }?> %</td>
					<td><?php if($siteVal['hardware']['maxRisk'] != "")    { echo $siteVal['hardware']['maxRisk']; }else{ echo 0; }?> %</td>
					<td><?php if($siteVal['application']['maxRisk'] != "") { echo $siteVal['application']['maxRisk']; }else{ echo 0; } ?> %</td>
					<td><?php echo $maxSite; ?> %</td>
				</tr>
				<?php endforeach; ?>
				<tr style="border-top: 5px solid #f00;">
					<td colspan="6"> MAX Risk for stakeholder </td>
					<td><?php echo $maxTotal; ?> %</td>
				</tr>
			</table>
			
			<input type="button" onclick="$('#migrationInfoContainer').remove()"  value="Close" />
                                                            
         </div>
     </div>
</div>
