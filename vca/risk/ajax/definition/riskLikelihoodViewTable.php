<?php 

	include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

?>

<table width="900">
	<tr class="table_header">
		<td align="center">            ID                 </td>
		<td align="center">            Likelihood Notes   </td>
		<td align="center">            Likelihood Percent </td>
		<td align="center">            Likelihood Scale   </td>
		<td align="center" width="50"> Edit               </td> <!-- TODO: SET EDIT -->
		<td align="center" width="50"> Delete             </td> <!-- TODO: SET DELETE -->
	</tr>
	
	<?php 
		$totalCoef = 0;
		$sql = "SELECT * FROM tdbRiskLikelihood";
		$res = mysql_query($sql);
		while($data = mysql_fetch_object($res)):
		//$totalCoef += $data->riskTypeCoef;
		
		
		if(($data->riskLikelihoodFromTime != 0 && $data->riskLikelihoodFromTime != "" ) && ( $data->riskLikelihoodToTime != 0 && $data->riskLikelihoodToTime != "" )) {
			$likeliTime = "From: $data->riskLikelihoodFromTime - $data->riskLikelihoodToTime years !";
		} else if($data->riskLikelihoodFromTime != 0 && $data->riskLikelihoodFromTime != "" ) {
			$likeliTime = " In more then $data->riskLikelihoodFromTime years !";
		} else if( $data->riskLikelihoodToTime != 0 && $data->riskLikelihoodToTime != "" ) {
			$likeliTime = " In less then $data->riskLikelihoodToTime years !";
		}
		
    ?>
	
	<tr>
		<td align="center"><?php echo $data->riskLikelihoodID;    ?>            </td>
		<td align="center"><?php echo $data->riskLikelihoodComment;  ?>         </td>
		<td align="center"><?php echo $data->riskLikelihoodPercent; ?>  %       </td>
		<td align="center">
			<?php echo $likeliTime; ?>       
		</td>
		<td align="center"><!-- TODO: SET EDIT -->
			<a title="Edit" title="Edit" onclick="editRiskLikelihood(<?php echo  $data->riskLikelihoodID; ?>)" >
				<img src="/images/ui/buttons/btn_edit.png" alt="Edit" />
			</a>
			
		</td>
		
		<td align="center"><!-- TODO: SET DELETE -->
			<a title="Delete" title="Delete" onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=delete&riskLikelihoodID=<?php echo  $data->riskLikelihoodID; ?>', '', '', true, '', false); getRiskLikelihoodTable('#riskLikelihoodTable'); clearForm('#riskLikelihoodForm'); hideIt('#riskLikelihoodFormDiv');" >
				<img src="/images/ui/buttons/btn_delete.png" alt="Edit" />
			</a>
			
		</td>	
		
	</tr>
			
		
			
			
	<?php		
		endwhile;
	?>
	
</table>