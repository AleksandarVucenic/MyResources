
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
?>
<!-- SHOW TYPE RISK -->
<table width="900">
    <tr class="table_header">
        <td align="center">            ID                </td>
        <td align="center">            Type Name         </td>
        <td align="center">            Type Coef.        </td>
        <td align="center">            Normal Ratio      </td>
        <td align="center" width="50"> Edit              </td> <!-- TODO: SET EDIT -->
        <td align="center" width="50"> Delete            </td> <!-- TODO: SET DELETE -->
    </tr>

    <?php
    $totalCoef = 0;
    $sql = "SELECT * FROM tdbRiskItemTypes";
    $res = mysql_query($sql);
    while ($data = mysql_fetch_object($res)):
        $totalCoef += $data->riskTypeCoef;
        ?>

        <tr>
            <td align="center"><?php echo $data->riskItemTypeID; ?>    </td>
            <td align="center"><?php echo $data->riskTypeName ?>        </td>
            <td align="center"><?php echo $data->riskTypeCoef; ?>         </td>
            <td align="center"><?php echo $data->riskTypeNormalRatio; ?> % </td>
            <td align="center"><!-- TODO: SET EDIT -->
                <a title="Edit" title="Edit" onclick="editRiskType(<?php echo $data->riskItemTypeID; ?>)" >
                    <img src="/images/ui/buttons/btn_edit.png" alt="Edit" />
                </a>

            </td>

            <td align="center"><!-- TODO: SET DELETE -->
                <a title="Delete" title="Delete" onclick="deleteRiskType(<?php echo $data->riskItemTypeID; ?>)" >
                    <img src="/images/ui/buttons/btn_delete.png" alt="Edit" />
                </a>

            </td>	

        </tr>




        <?php
    endwhile;
    ?>
    <tr>
        <td></td>
        <td></td>
        <td align="center" style="background: #ccc;"><strong style="margin-left: 10px;">TOTAL: </strong><?php echo $totalCoef; ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>