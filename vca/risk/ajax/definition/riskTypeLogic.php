<?php

//var_dump($_POST);

include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");


$userID = $_SESSION['userID'];
$action = $_GET['action'];

/* SAVE & UPDATE
 * =================================================================
 * */
if ($action == "update" OR $action == "save") {
    $dataPost = (object) $_POST;

    $data = "
			
        `riskTypeName`='$dataPost->riskTypeNameForm',
        `riskTypeCoef`='$dataPost->riskTypeCoefForm',
        `riskTypeNormalRatio`='$dataPost->riskTypeNormalRatioForm',
    ";
    
    //var_dump($dataPost);
    if ($action == "save") {
        $data .= "
            `createdBy`='$userID',
            `createdDate`='$lastUpdate'
        ";
        $sql = "INSERT INTO `tdbRiskItemTypes` SET $data";
        $messageTask = " saved ";
    }

    if ($action == "update") {

        $data .= "
				`userID`='$userID',
				`lastUpdate`='$lastUpdate'
			";
        $sql = "UPDATE `tdbRiskItemTypes` SET $data WHERE `riskItemTypeID` = " . $_POST['riskTypeIDForm'];
        $messageTask = " updated ";
    }
    $res = mysql_query($sql);

    if ($res) {
        $messageStatus = "Successful $messageTask risk type!";
    } else {
        $messageStatus = "Unsuccessfull request !";
    }

    echo '<script type="text/javascript">showOverlayMessage("' . $messageStatus . '", "warning", true); </script>';
}


/* DELETE
 * =================================================================
 * */
if ($action == "delete") {
    $sql = "DELETE FROM `tdbRiskItemTypes` WHERE `riskItemTypeID` =  " . $_GET['riskItemTypeID'];
    $res = mysql_query($sql);

    if ($res) {
        $messageStatus = "Succesfull deleted risk classification!";
    } else {
        $messageStatus = "Unsuccessfull deleted risk classification!";
    }

    echo '<script type="text/javascript">showOverlayMessage("' . $messageStatus . '", "warning", true); </script>';
}

/* EDIT
 * =================================================================
 * */
if ($action == "edit") {
    $sql = " SELECT * FROM `tdbRiskItemTypes` WHERE riskItemTypeID = " . $_GET['riskTypeID'] . " LIMIT 0,1";
    $res = mysql_query($sql);

    //var_dump(mysql_num_rows($res));
    $dataJS = array();
    while ($data = mysql_fetch_array($res)) {
        $dataJS['riskTypeIDForm'] = $data['riskItemTypeID'];
        $dataJS['riskTypeNameForm'] = $data['riskTypeName'];
        $dataJS['riskTypeNormalRatioForm'] = $data['riskTypeNormalRatio'];
        $dataJS['riskTypeCoefForm'] = $data['riskTypeCoef'];
    }
    //var_dump($dataJS);
    echo json_encode($dataJS);
}



?>