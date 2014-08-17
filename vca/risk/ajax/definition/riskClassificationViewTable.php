<?php 

	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

?>

<table width="900">
	<tr class="table_header">
		<td align="center">            ID            </td>
		<td align="center">            Risk Name     </td>
		<td align="center">            Risk Level    </td>
		<td align="center">            Risk Cost </td>
		<td align="center">            Risk Value    </td>
		<td align="center" width="50"> Edit          </td> <!-- TODO: SET EDIT -->
		<td align="center" width="50"> Delete        </td> <!-- TODO: SET DELETE -->
	</tr>
	
	<?php 
	
		$sql = "SELECT r . * , min( v.riskValue ) AS maxRisk, max( m.riskValue ) AS minRisk
				FROM tdbRiskClassification AS r
				LEFT JOIN tdbRiskClassification AS v ON r.riskValue < v.riskValue
				LEFT JOIN tdbRiskClassification AS m ON r.riskValue >= m.riskValue
				GROUP BY r.riskID";
		$res = mysql_query($sql);
		while($data = mysql_fetch_object($res)):
		
		$maxRisk = $data->maxRisk;
		if(($data->riskValue != "" AND $data->riskValue != NULL) AND $maxRisk == NULL)
		{
			$maxRisk = 100;
		}
		
		if($data->riskValue != 0){ $data->riskValue = $data->riskValue + 1; }
    ?>
	
	<tr>
		<td align="center">                                                                    <?php echo $data->riskID;    ?>   </td>
		<td align="center">                                                                    <?php echo $data->riskName   ?>   </td>
		<td align="center">                                                                    <?php echo $data->riskLevel; ?>   </td>
		<td align="center">                               <?php echo $data->riskCostGrade;  ?> <?php echo $data->riskCost;  echo " <strong> ".displayCurrency($data->riskCurrency). " </strong> "; ?>   </td>
		<td align="center" style="background: <?php echo $data->riskClassificationColor; ?>; color: #000;" > <?php echo $data->riskValue .' - '.$maxRisk; ?> % </td>
		<td align="center"><!-- TODO: SET EDIT -->
			<a title="Edit" title="Edit" onclick="editRiskClassificatoin(<?php echo $data->riskID; ?>)" >
				<img src="/images/ui/buttons/btn_edit.png" alt="Edit" />
			</a>
			
		</td>
		<td align="center"><!-- TODO: SET DELETE -->
			<a title="Delete" title="Delete" onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskClassificationLogic.php?action=delete&riskID=<?php echo  $data->riskID; ?>', '', '', true, '', false); getRiskClassificationTable('#riskClassificationTable'); clearForm('#riskClassificationForm'); hideIt('#riskClassificationFormDiv');"  >
				<img src="/images/ui/buttons/btn_delete.png" alt="Edit" />
			</a>
			
		</td>
	</tr>
			
			
			
			
	<?php		
		endwhile;
		
	?>
	
</table>