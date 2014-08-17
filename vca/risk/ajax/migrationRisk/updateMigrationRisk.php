<script>
    
</script>
<?php 
    include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");

    $externalID = $_GET['externalID'];
    $typeID     = $_GET['typeID'];
    $siteID     = $_GET['siteID'];
    
    $dataPost = (object) $_POST;
    
    if($dataPost->migrationLikelihoodFrom != ""){ $dataPost->migrationLikelihoodFrom = strtotime(str_replace('/', '-', $dataPost->migrationLikelihoodFrom)); }
    if($dataPost->migrationLikelihoodTo != "")  { $dataPost->migrationLikelihoodTo   = strtotime(str_replace('/', '-', $dataPost->migrationLikelihoodTo)); }
    
    $sqlData = array();
    $message = "";
    $messageType = "info";
    $siteData = json_decode($siteID);
    //echo "<script>alert(JSON.stringify(".json_encode($siteID)."));</script>";
    
    if(is_array(json_decode($siteID))) {
        $insertCheck = true;
        foreach(json_decode($siteID) as $index => $value) {
            //echo "<script>alert(JSON.stringify($value));</script>";
            $data = "
                `riskMigValue` = '$dataPost->migrationValue',
                `riskMigComment` = '$dataPost->migrationComment',
                `riskMigLikeFrom` = '$dataPost->migrationLikelihoodFrom',
                `riskMigLikeTo` = '$dataPost->migrationLikelihoodTo',
                `createdBy` = '$userID',
                `createdDate` = '$lastUpdate',
                `riskMigExternalID` = '$externalID',
                `riskMigType` = '$typeID',
                `riskMigSiteID` = '$value'
            ";
            
            $sql = "INSERT INTO tdbRiskMigrationData SET $data ";
            $res = mysql_query($sql);
            
            if(!$res){
                $insertCheck = false;
            }    
        }
        
        if($insertCheck == true) {
            $message = "Success upated all risk migration data.";
        }else{
            $message = "Unsuccess update risk data.";
            $messageType = "warning";
        }
        
        
    }else{
        $siteID = (int) str_replace('"',"" , $siteID); // Convert from string to Int | Didnt know better way for this
        $data = "
            `riskMigValue` = '$dataPost->migrationValue',
            `riskMigComment` = '$dataPost->migrationComment',
            `riskMigLikeFrom` = '$dataPost->migrationLikelihoodFrom',
            `riskMigLikeTo` = '$dataPost->migrationLikelihoodTo',
            `createdBy` = '$userID',
            `createdDate` = '$lastUpdate',
            `riskMigExternalID` = '$externalID',
            `riskMigType` = '$typeID',
            `riskMigSiteID` = '$siteID'
        ";
        
        $sql = "INSERT INTO tdbRiskMigrationData SET $data ";
        $res = mysql_query($sql);
        
        if($res){
            $message = "Sucessful updated risk migration.";
            //clearRiskMigHistroy($externalID, $typeID, $siteID);
        }else{
            $message = "Unsuccesfull update of risk migration.";
            $messageType = "warning";
        }
        
        
    }
    
    $messageTask ="Succesful ";
    //if(!$res) { $messageTask = "Unsuccessful "; }
    //var_dump($res);

?>
<script>
    //alert(JSON.stringify(<?php echo json_encode($siteID); ?>));
    showOverlayMessage('<?php  echo $message; ?> ', '<?php echo $messageType;?>', true);
    //alert(<?php echo is_int($_GET['siteID']);?>);
</script>

