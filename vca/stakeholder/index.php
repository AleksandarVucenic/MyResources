<?php	
		session_start(); 
		include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
		
		$back = "/";
		$home = "/";
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--<meta http-equiv="X-UA-Compatible" content="IE=9" >-->
	<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Transition Management Platform</title>
<link rel="stylesheet" type="text/css" href="/style/960.css"/>
<link rel="stylesheet" type="text/css" href="/style/base.css"/>
<link rel="stylesheet" type="text/css" href="/style/style.css"/>
<script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="/stakeholder/js/stakeholder.js"></script>
<script type="text/javascript" src="/managetpc/risk/js/risk.js"></script>
</head>

<body>
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
    <div class="container_12 top_rounded"></div>
    <div class="container_12 top_nav">
          <div class="grid_4" style="vertical-align:middle"> 
	        <a href="<?php echo $back; ?>">
	        <img src="/images/ui/buttons/back.png" title="Back" alt="Back" border="0" /></a>	            	
	        <a href="<?php echo $home; ?>" >
	        <img src="/images/ui/buttons/home_top.png" title="Home" alt="Home" border="0" /></a>
          </div>
          <div class="grid_4">&nbsp;
          </div> 
          <?php include ($_SERVER['DOCUMENT_ROOT']."/include/nav.php") ?>
    </div>
    <div class="container_12 background-main">
    	<div class="content">
    	<br />
		    <fieldset style="float: left"><legend>Stakeholder View by</legend>
			    <table bgcolor="#fff" width="25%" border="0" cellpadding="0" cellspacing="0">
			    	<tr>
			    		<td>
			 				<?php listValues("tdbEmployeeConnection", "description", "description", $lines = "1", "stakeholderConn(this.value)", "", "`description`", $class = "w250", $info = false, $where = "",  @$sessionRegionID, "", "`description`"); ?> 	                           	
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>
			    			<div id="stakeholderConn"></div>
			    		</td>
			    	</tr>
			    </table>
			</fieldset>
		    <table bgcolor="#fff" width="70%" border="0" cellpadding="0" cellspacing="0">
		    	<tr>
		    		<td>
		    			<div id="employees"></div>
		    		</td>
		    	</tr>
		    </table>
		<br />
		</div>
	</div>
	<div align="left" class="container_12 top_nav">
    <div class="grid_4">
        <a href="<?php echo $back; ?>">
        <img src="/images/ui/buttons/back.png" title="Back" alt="Back" border="0" /></a>
        <a href="<?php echo $home; ?>" ><img src="/images/ui/buttons/home_top.png" title="Home" alt="Home" border="0" /></a>
      </div>
    </div> 
    <div class="container_12 bottom_rounded"></div> 
	<div class="container_12 footer"><?php include($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?></div>

</body>
</html>
